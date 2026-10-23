<?php

namespace Tests\Feature;

use App\Enums\SmsTemplate;
use App\Models\Order;
use App\Services\OrderService;
use App\Services\Sms\SmsService;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Mockery;
use Tests\TestCase;

class OrderCompletionSmsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->string('phone');
            $table->string('tracking_code');
            $table->timestamps();
        });
    }

    public function test_payment_sends_order_number_once_after_commit(): void
    {
        $order = Order::create(['status' => 'ready_to_pay', 'phone' => '09120000000', 'tracking_code' => '26123456']);
        $sms = Mockery::mock(SmsService::class);
        $sms->shouldReceive('sendTemplate')->once()
            ->with('09120000000', SmsTemplate::COMPLETE_ORDER, ['ORDER_NUMBER' => '26123456'])
            ->andReturnUsing(function () use ($order) {
                $this->assertSame('paid', $order->fresh()->status);
                $this->assertSame(0, \DB::transactionLevel());
                return true;
            });
        $this->app->instance(SmsService::class, $sms);

        app(OrderService::class)->markAsPaid($order);
        app(OrderService::class)->markAsPaid($order);
        $this->assertSame(266468, SmsTemplate::COMPLETE_ORDER->id());
    }

    public function test_sms_error_does_not_undo_payment(): void
    {
        $order = Order::create(['status' => 'ready_to_pay', 'phone' => '09120000000', 'tracking_code' => '26123456']);
        $sms = Mockery::mock(SmsService::class);
        $sms->shouldReceive('sendTemplate')->once()->andThrow(new \RuntimeException('Unavailable'));
        $this->app->instance(SmsService::class, $sms);

        app(OrderService::class)->markAsPaid($order);
        $this->assertSame('paid', $order->fresh()->status);
    }

    public function test_unpaid_order_does_not_send_sms(): void
    {
        $order = Order::create(['status' => 'pending', 'phone' => '09120000000', 'tracking_code' => '26123456']);
        $sms = Mockery::mock(SmsService::class);
        $sms->shouldNotReceive('sendTemplate');
        $this->app->instance(SmsService::class, $sms);

        $this->expectException(\Exception::class);
        app(OrderService::class)->markAsPaid($order);
    }
}
