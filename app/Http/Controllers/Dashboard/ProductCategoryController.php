<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductCategory;
use DB;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductCategoryController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::all();
        $categories = Category::all();
        $productCategories = ProductCategory::select(
            'product_categories.*',
            'categories.name as category',
            'products.name as product'
        )
            ->join('products', 'product_categories.product_id', '=', 'products.id')
            ->join('categories', 'product_categories.category_id', '=', 'categories.id')
            ->when($request->q, function ($query, $q) {
                $query->where('products.name', 'like', '%' . $q . '%');
                $query->orWhere('categories.name', 'like', '%' . $q . '%');
            })->latest()->paginate(10);

        return Inertia::render('Admin/ProductCategory/Index', [
            'productCategories' => $productCategories,
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'category_id' => 'required|exists:categories,id'
        ]);

        DB::beginTransaction();

        try {
            if (!$data) {
                return redirect()->back()->with('error', 'Failed to add Product Category');
            }

            ProductCategory::create([
                'product_id' => $data['product_id'],
                'category_id' => $data['category_id'],
            ]);

            DB::commit();

            return redirect()->route('product_category.index')->with('success', 'Success to add Product Category');
        }
        catch (\Throwable $e) {
            DB::rollback();

            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
