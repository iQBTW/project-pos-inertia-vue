<?php

namespace App\Http\Controllers\Dashboard;

use Inertia\Inertia;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        return Inertia::render('Admin/Product/Create', [
            'categories' => Category::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:products,name|max:255',
            'stock' => 'required|numeric',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'images' => 'required|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        DB::beginTransaction();

        try {
            $product = new Product;
            $product->name = $validated['name'];
            $product->stock = $validated['stock'];
            $product->price = $validated['price'];
            $product->category_id = $validated['category_id'];
            $product->save();

            foreach ($request->file('images') as $imageFiles) {
                $images = new ProductImage;
                $fileName = $imageFiles->getClientOriginalName();
                $path = $imageFiles->storeAs('product', $fileName, 'public');
                $images->image = $path;
                $images->product_id = $product->id;
                $images->save();
            }

            DB::commit();

            return redirect(route('product.index'))->with('success', 'Product created successfully');
        }
        catch (\Throwable $e) {
            DB::rollBack();

            return redirect()->back()->with('error', $e->getMessage());
        }
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
    public function edit($id)
    {
        $product = Product::with('product_images')->findOrFail($id);
        $product->price = number_format($product->price, 0, '.', '');

        return Inertia::render('Admin/Product/Edit', [
            'categories' => Category::all(),
            'product' => $product,
            'productImage' => $product->product_images
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $product = Product::with('product_images')->findOrFail($id);

        $validated = $request->validate([
            'name' => 'max:255',
            'stock' => 'numeric',
            'price' => 'numeric',
            'category_id' => 'exists:categories,id',
            'productImage' => 'image|mimes:jpeg,jpg,png|max:2048',
        ]);

        DB::beginTransaction();

        try {
            $product->name = $validated['name'];
            $product->stock = $validated['stock'];
            $product->price = $validated['price'];
            $product->category_id = $validated['category_id'];
            $product->save();

            foreach ($request->file('productImage') as $imagesFile) {
                $product_image = new ProductImage;
                $fileName = $imagesFile->getClientOriginalName();
                $path = $imagesFile->storeAs('product', $fileName, 'public');
                $product_image->image = $path;
                $product_image->product_id = $product->id;
                $product_image->save();
            }

            DB::commit();

            return redirect(route('product.index'))->with('success', 'Product has been updated succesfully');
        }
        catch (\Throwable $e) {
            DB::rollback();

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect(route('product.index'))->with('success', 'Product has been deleted succesfully');
    }
}
