<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::where('stock', '>', 0)
            ->with('category')
            ->latest()
            ->take(8)
            ->get();

        $categories = Category::with('products')->get();

        return view('home', compact('featuredProducts', 'categories'));
    }
}
