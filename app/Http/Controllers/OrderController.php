<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class OrderController extends Controller
{
    public function placeOrder(Request $request)
    {
        $cart = Redis::hgetall('cart:' . auth()->id());
        if (empty($cart)) return response()->json(['error' => 'Cart is empty'], 400);

        $items = [];
        $totalPrice = 0;

        foreach ($cart as $productId => $quantity) {
            $product = Product::find($productId);
            if ($product) {
                $items[] = ['product' => $product, 'quantity' => $quantity];
                $totalPrice += $product->price * $quantity;
            }
        }

        $order = Order::create([
            'user_id' => auth()->id(),
            'items' => json_encode($items),
            'total_price' => $totalPrice,
        ]);

        Redis::del('cart:' . auth()->id());
        return response()->json(['message' => 'Order placed successfully', 'order' => $order], 201);
    }

    public function viewOrders()
    {
        $orders = Order::where('user_id', auth()->id())->get();
        return response()->json(['orders' => $orders], 200);
    }
}