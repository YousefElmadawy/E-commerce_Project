<?php

namespace App\Http\Controllers\Front;

use App\Contracts\CartContract;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Repositories\CartRepository;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(public CartContract $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('front.cart', [
            'cart' => $this->repository
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['nullable', 'integer', 'min:1']
        ]);
        $product = Product::findOrFail($request->post('product_id'));
        $this->repository->add($product, $request->post('quantity'));
        if ($request->expectsJson()) {
            
            return response()->json([
                'message' => 'Item added to cart!',
            ], 201);
        }
        
        return redirect()->route('cart.index')
            ->with('success', 'Product added to cart!');
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['nullable', 'integer', 'min:1']
        ]);
        $product = Product::findOrFail($request->post('product_id'));
        $this->repository->update($product, $request->post('quantity'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
