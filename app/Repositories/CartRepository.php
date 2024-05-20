<?php

namespace App\Repositories;

use App\Contracts\CartContract;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartRepository implements CartContract
{
    public function __construct(public Cart $cart)
    {
        $this->cart = $cart;
    }

    public function get()
    {
        return Cart::with('product')->get();
    }

    public function add(Product $product, $quantity = 1)
    {
        $item = Cart::where('product_id', '=', $product->id)->first();
        if (!$item) {
            return Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $quantity
            ]);
        }
        return $item->increment('quantity', $quantity);
    }
    public function update(Product $product, $quantity)
    {
        Cart::where('product_id', '=', $product->id)
            ->update([
                'quantity' => $quantity,
            ]);
    }
    public function delete($id)
    {
        Cart::where('id', $id)->delete();
    }
    public function empty()
    {
        Cart::query()->delete();
    }
    public function total()
    {
        return $this->get()->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });
    }
}
