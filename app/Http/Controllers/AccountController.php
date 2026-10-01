<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $orders = Order::with('items.product')->withCount('items')
            ->where('user_id', $user->id)
            ->whereHas('items')
            ->latest()
            ->paginate(10);

        $stats = [
            'orders' => Order::where('user_id', $user->id)->whereNotIn('status', ['pending', 'canceled'])->count(),
            'paid' => Order::where('user_id', $user->id)->whereIn('status', ['paid', 'shipped', 'completed'])->sum('final_price'),
            'open_cart' => Order::where('user_id', $user->id)->where('status', 'pending')->whereHas('items')->exists(),
        ];

        return view('site.pages.account.index', compact('user', 'orders', 'stats'));
    }

    public function show(Request $request, Order $order)
    {
        $user = auth()->user();
        abort_unless($order->user_id === $user->id, 404);
        $order->load(['items.product.mediaFiles', 'items.attributeValues.attribute', 'shipment', 'transactions']);

        return view('site.pages.account.order', compact('user', 'order'));
    }
}
