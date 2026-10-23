<?php

namespace Tests\Feature;

use App\Services\Sms\Providers\SmsIrProvider;
use Illuminate\Support\Facades\Http;
use Mockery;
use Tests\TestCase;

class SmsIrProviderTest extends TestCase
{
    public function test_otp_uses_configured_template_and_code_parameter(): void
    {
        config(['services.smsir.api_key' => 'test-key', 'services.smsir.otp_template_id' => 296347]);
        Http::preventStrayRequests();
        Http::fake(['api.sms.ir/*' => Http::response(['status' => 1, 'message' => 'OK', 'data' => []])]);
        Mockery::mock('alias:App\\Models\\SmsLog')->shouldReceive('create')->once()
            ->with(Mockery::on(fn ($log) => $log['status'] === 'sent' && $log['template_id'] === 296347));

        $this->assertTrue((new SmsIrProvider)->sendTemplate('09120000000', 'otp_code', ['CODE' => '654987']));

        Http::assertSent(fn ($request) => $request->url() === 'https://api.sms.ir/v1/send/verify'
            && $request->hasHeader('x-api-key', 'test-key')
            && $request->data() === [
                'mobile' => '09120000000',
                'templateId' => 296347,
                'parameters' => [['name' => 'CODE', 'value' => '654987']],
            ]);
        Http::assertSentCount(1);
    }

    public function test_provider_rejection_is_reported_as_failure(): void
    {
        config(['services.smsir.api_key' => 'test-key']);
        Http::preventStrayRequests();
        Http::fake(['api.sms.ir/*' => Http::response(['status' => 0, 'message' => 'Rejected'], 400)]);
        Mockery::mock('alias:App\\Models\\SmsLog')->shouldReceive('create')->once()
            ->with(Mockery::on(fn ($log) => $log['status'] === 'failed' && $log['sent_at'] === null));

        $this->assertFalse((new SmsIrProvider)->sendTemplate('09120000000', 'otp_code', ['CODE' => '654987']));
    }
}
