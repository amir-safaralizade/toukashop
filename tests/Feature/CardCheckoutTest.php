<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use App\Services\OrderService;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Mockery;
use Tests\TestCase;

class CardCheckoutTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Schema::create('properties', function (Blueprint $t) {
            $t->id(); $t->string('title'); $t->string('type'); $t->string('value')->nullable();
        });
        Schema::create('provinces', function (Blueprint $t) { $t->id(); });
        Schema::create('cities', function (Blueprint $t) { $t->id(); $t->integer('province_id'); });
        Schema::create('products', function (Blueprint $t) { $t->id(); $t->integer('transportation_unit')->default(0); });
        Schema::create('orders', function (Blueprint $t) {
            $t->id(); $t->integer('user_id'); $t->string('status');
            foreach (['total_price', 'discount_amount', 'final_price'] as $column) $t->integer($column)->default(0);
            foreach (['fullname', 'phone', 'notes', 'payment_method'] as $column) $t->string($column)->nullable();
            $t->timestamps();
        });
        Schema::create('order_items', function (Blueprint $t) {
            $t->id(); $t->integer('order_id'); $t->integer('product_id')->nullable();
        });
        Schema::create('shipments', function (Blueprint $t) {
            $t->id(); $t->integer('order_id');
            foreach (['status', 'shipping_provider', 'tracking_number', 'postal_code', 'shipping_address'] as $column) $t->string($column)->nullable();
            foreach (['shipping_province_id', 'shipping_city_id', 'shipping_cost'] as $column) $t->integer($column);
            $t->timestamps();
        });
        Schema::create('transactions', function (Blueprint $t) {
            $t->id(); $t->morphs('payable'); $t->integer('amount');
            foreach (['gateway', 'status', 'our_token'] as $column) $t->string($column);
            $t->string('request_ip')->nullable(); $t->timestamps();
        });
        DB::table('provinces')->insert(['id' => 1]);
        DB::table('cities')->insert(['id' => 1, 'province_id' => 1]);
        DB::table('orders')->insert(['id' => 1, 'user_id' => 7, 'status' => 'pending', 'total_price' => 100000]);
        DB::table('order_items')->insert(['order_id' => 1]);
        $user = new User;
        $user->forceFill(['id' => 7, 'is_guest' => false]);
        $this->actingAs($user);
        $this->withoutMiddleware();
        // Stock reservation has its own tests; isolate checkout persistence here.
        $service = Mockery::mock(OrderService::class);
        $service->shouldReceive('finalizeOrder')->once()->andReturnUsing(function ($order) {
            $order->update(['status' => 'ready_to_pay']);
        });
        $this->app->instance(OrderService::class, $service);
    }

    private function checkout(): \Illuminate\Testing\TestResponse
    {
        return $this->post(route('cart.finalize'), [
            'fullname' => 'Customer', 'phone' => '09120000000', 'postal_code' => '1234567890',
            'shipping_province_id' => 1, 'shipping_city_id' => 1,
            'shipping_address' => 'Test address', 'shipping_method' => 'Vanguard_Post', 'payment_method' => 'card',
        ]);
    }

    public function test_card_order_and_payment_are_saved_before_redirecting_to_customer_order(): void
    {
        $this->checkout()->assertRedirect(route('account.orders.show', 1))->assertSessionHasNoErrors();
        $order = Order::findOrFail(1);
        $this->assertSame('need_admin_approval', $order->status);
        $this->assertSame('card', $order->payment_method);
        $payment = $order->transactions()->sole();
        $this->assertEquals($order->id, $payment->payable_id);
        $this->assertSame(Order::class, $payment->payable_type);
        $this->assertSame('manual', $payment->gateway);
        $this->assertSame('pending', $payment->status);
        $this->assertEquals($order->final_price, $payment->amount);
    }

    public function test_payment_failure_rolls_back_order_finalization(): void
    {
        Schema::drop('transactions');
        $this->withoutExceptionHandling();
        try {
            $this->checkout();
            $this->fail('Expected payment persistence to fail.');
        } catch (\Illuminate\Database\QueryException $exception) {
            $this->assertSame('pending', Order::findOrFail(1)->status);
            $this->assertSame(0, DB::table('shipments')->count());
        }
    }
}
