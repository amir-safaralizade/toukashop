<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\OrderItem;
use App\Services\CartCleanupService;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class CartCleanupTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Schema::create('products', function (Blueprint $t) { $t->id(); $t->boolean('status'); });
        Schema::create('orders', function (Blueprint $t) {
            $t->id(); $t->string('status');
            foreach (['total_price', 'discount_amount', 'final_price', 'shipping_cost'] as $field) $t->integer($field)->default(0);
            $t->timestamps();
        });
        Schema::create('order_items', function (Blueprint $t) {
            $t->id(); $t->unsignedBigInteger('order_id'); $t->unsignedBigInteger('product_id'); $t->integer('total_price'); $t->timestamps();
        });
        Schema::create('order_item_attribute_values', function (Blueprint $t) { $t->unsignedBigInteger('order_item_id'); $t->unsignedBigInteger('attribute_value_id'); });
        DB::table('products')->insert([['id' => 1, 'status' => true], ['id' => 21, 'status' => false]]);
    }

    public function test_missing_and_disabled_products_are_removed_and_totals_recalculated(): void
    {
        $cart = Order::create(['status' => 'pending', 'total_price' => 300, 'discount_amount' => 25]);
        foreach ([1, 21, 999] as $id) DB::table('order_items')->insert(['order_id' => $cart->id, 'product_id' => $id, 'total_price' => 100]);
        $this->assertSame(2, app(CartCleanupService::class)->clean($cart));
        $this->assertSame([1], $cart->items()->pluck('product_id')->all());
        $this->assertEquals(100, $cart->fresh()->total_price);
        $this->assertEquals(75, $cart->fresh()->final_price);
        $this->assertSame(0, app(CartCleanupService::class)->clean($cart));
    }

    public function test_four_items_of_a_disabled_product_leave_an_empty_valid_cart(): void
    {
        $cart = Order::create(['status' => 'pending', 'total_price' => 400, 'discount_amount' => 100, 'shipping_cost' => 50]);
        for ($i = 0; $i < 4; $i++) DB::table('order_items')->insert(['order_id' => $cart->id, 'product_id' => 21, 'total_price' => 100]);
        $this->assertSame(4, app(CartCleanupService::class)->clean($cart));
        $this->assertSame(0, $cart->items()->count());
        $this->assertEquals(0, $cart->fresh()->final_price);
        $this->assertEquals(0, $cart->fresh()->discount_amount);
        $this->assertEquals(0, $cart->fresh()->shipping_cost);
    }

    public function test_historical_orders_are_preserved_and_disabled_product_stays_visible(): void
    {
        foreach (['paid', 'shipped', 'completed', 'ready_to_pay'] as $status) {
            $order = Order::create(['status' => $status, 'total_price' => 100, 'final_price' => 100]);
            $item = OrderItem::create(['order_id' => $order->id, 'product_id' => 21, 'total_price' => 100]);
            $this->assertSame(0, app(CartCleanupService::class)->clean($order));
            $this->assertTrue($order->items()->exists());
            $this->assertNotNull($item->product);
            $this->assertEquals(100, $order->fresh()->final_price);
        }
    }
}
