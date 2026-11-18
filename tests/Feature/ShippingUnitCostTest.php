<?php
namespace Tests\Feature;

use App\Http\Controllers\CartController;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ShippingUnitCostTest extends TestCase
{
    public function test_default_configured_and_zero_unit_costs(): void
    {
        Schema::create('properties', function (Blueprint $t) {
            $t->id(); $t->string('title'); $t->string('type'); $t->string('value')->nullable();
        });
        DB::table('properties')->insert(['title' => 'shipping-cost', 'type' => 'number', 'value' => '50000']);
        $order = new Order;
        $order->setRelation('items', collect([2, 1])->map(function ($units) {
            $item = new OrderItem;
            $item->setRelation('product', new Product(['transportation_unit' => $units]));
            return $item;
        }));
        $method = new \ReflectionMethod(CartController::class, 'calculateShippingCost');
        $controller = app(CartController::class);
        $this->assertSame(80000, $method->invoke($controller, $order));
        DB::table('properties')->insert(['title' => 'shipping-unit-cost', 'type' => 'number', 'value' => '20000']);
        $this->assertSame(110000, $method->invoke($controller, $order));
        DB::table('properties')->where('title', 'shipping-unit-cost')->update(['value' => '0']);
        $this->assertSame(50000, $method->invoke($controller, $order));
        DB::table('properties')->where('title', 'shipping-unit-cost')->update(['value' => null]);
        $this->assertSame(80000, $method->invoke($controller, $order));
    }
}
