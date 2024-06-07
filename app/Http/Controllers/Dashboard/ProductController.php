<?php

namespace App\Http\Controllers\Dashboard;

use Inertia\Inertia;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::with('categories')
            ->select(
                'products.*',
                'categories.name as category',
                'product_images.image as image'
            )
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('product_images', 'product_images.product_id', '=', 'products.id')
            ->when($request->q, function ($query, $q) {
                $query->where('products.name', 'like', '%' . $q . '%');
                $query->orWhere('categories.name', 'like', '%' . $q . '%');
            })->paginate(10);

        foreach ($products as $product) {
            $product->price = currencyFormat($product->price);
        }

        return Inertia::render('Admin/Product/Index', [
            'products' => $products,
            'search' => $request->only('q'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
