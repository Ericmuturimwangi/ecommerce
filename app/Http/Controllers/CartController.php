<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class CartController extends Controller
{
    public function addItem(Request $request)
    {
        Redis::hincrby('cart:' . auth()->id(), $request->input('product_id'), $request->input('quantity', 1));
        return response()->json(['message' => 'Item added to cart'], 200);
    }

    public function removeItem($productId)
    {
        Redis::hdel('cart:' . auth()->id(), $productId);
        return response()->json(['message' => 'Item removed from cart'], 200);
    }

    public function viewCart()
    {
        $cart = Redis::hgetall('cart:' . auth()->id());
        return response()->json(['cart' => $cart], 200);
    }
}