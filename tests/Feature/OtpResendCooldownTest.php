<?php

namespace Tests\Feature;

use App\Http\Controllers\OTPController;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class OtpResendCooldownTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config(['services.sms_fake_mode' => true]);
        RateLimiter::clear('otp-resend:09121234567');
        RateLimiter::clear('otp:09121234567|127.0.0.1');
        Schema::create('verification_codes', function (Blueprint $table) {
            $table->id();
            $table->string('phone');
            $table->string('code');
            $table->string('channel');
            $table->boolean('verified')->default(false);
            $table->integer('attempts')->default(0);
            $table->timestamp('expires_at');
            $table->timestamps();
        });
    }

    private function send(string $ip = '127.0.0.1')
    {
        $request = Request::create('/send-otp', 'POST', [
            'phone' => '09121234567', 'purpose' => 'authenticate',
        ], [], [], ['REMOTE_ADDR' => $ip]);

        return app(OTPController::class)->send($request);
    }

    public function test_resending_is_blocked_for_two_minutes_without_replacing_the_code(): void
    {
        $this->assertSame(120, $this->send()->getData(true)['retry_after']);
        $id = DB::table('verification_codes')->value('id');
        $this->travel(119)->seconds();
        $response = $this->send('127.0.0.2');
        $this->assertSame(429, $response->getStatusCode());
        $this->assertSame(1, $response->getData(true)['retry_after']);
        $this->assertTrue($response->getData(true)['code_sent']);
        $this->assertEquals($id, DB::table('verification_codes')->value('id'));
    }

    public function test_resending_is_enabled_after_two_minutes(): void
    {
        $this->send();
        $id = DB::table('verification_codes')->value('id');
        $this->travel(120)->seconds();
        $response = $this->send();
        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame(120, $response->getData(true)['retry_after']);
        $this->assertNotEquals($id, DB::table('verification_codes')->value('id'));
        $this->assertSame(1, DB::table('verification_codes')->count());
    }
}
