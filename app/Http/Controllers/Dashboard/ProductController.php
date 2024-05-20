<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductReuest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Scopes\StoreScope;
use App\Models\Store;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\Helper;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    use Helper;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $products = Product::withoutGlobalScope(StoreScope::class)->paginate(5);

        //withScope to get products that = store_id about user
        $products = Product::latest()->paginate(5);

        return view('dashboard.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $stores = Store::all();
        $categories = Category::active()->get();
        return view('dashboard.products.create', compact('categories', 'stores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductReuest $request)
    {
        $date = $request->validated();

        $date = $request->merge([
            'slug' => Str::slug($request->name)
        ]);
        $date = $request->except('image');
        $date['image'] = $this->uploadImage($request);


        Product::create($date);
        return to_route('products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $stores = Store::all();
        $categories = Category::active()->get();
        return view('dashboard.products.edit', compact('categories', 'stores', 'product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $date = $request->validate([
            'name' => 'sometimes|required',
            'store_id' => 'sometimes|required',
            'image' => 'sometimes|required',
            'description' => 'sometimes|required',
            'status' => 'sometimes|required',
            'category_id' => 'sometimes|required',
            'price' => 'sometimes|required|numeric',
            'compare_price' => 'sometimes|required',
        ]);
        $product->update($date);
        return to_route('products.index');
    }
    public function destroy(Product $product)
    {
        $product->delete();
        return to_route('products.index');
    }
    public function trash()
    {
        $products = Product::onlyTrashed()->paginate();
        return view('dashboard.products.trash', compact('products'));
    }
    public function restore($id)
    {
        $product=Product::onlyTrashed()->findOrFail($id);
        $product->restore();
        return redirect()->route('products.trash')->with('sucess', 'Category restored');
    }
}
