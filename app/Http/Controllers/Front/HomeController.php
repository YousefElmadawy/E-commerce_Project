<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Scopes\StoreScope;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::withoutGlobalScope(StoreScope::class)
            ->with('category')
            ->active()
            ->latest()
            ->limit(8)
            ->get();
        return view('front.index', compact('products'));
    }
}
