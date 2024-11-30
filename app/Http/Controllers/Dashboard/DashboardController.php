<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\OrderProduct;
use App\Models\ProductCategory;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $orderTotal = Order::count();
        $productTotal = Product::count();
        $userTotal = User::count();
        $categories = Category::get();

        $bestSellingProducts = OrderProduct::select(
            'products.id as product_id',
            'products.name as product',
            'products.price as price',
            'product_images.image as image',
            DB::raw('COUNT(order_products.id) as order_count')
        )
            ->join('products', 'order_products.product_id', '=', 'products.id')
            ->leftjoin('product_images', 'products.id', '=', 'product_images.product_id')
            ->groupBy('products.id', 'products.name', 'product_images.image')
            ->orderBy('order_count', 'desc')
            ->get();

        $orderCountByCategory = DB::table('categories')
            ->leftjoin('product_categories', 'categories.id', '=', 'product_categories.category_id')
            ->leftjoin('products', 'product_categories.product_id', '=', 'products.id')
            ->leftjoin('order_products', 'products.id', '=', 'order_products.product_id')
            ->leftjoin('orders', 'order_products.order_id', '=', 'orders.id')
            ->select('categories.name as category', DB::raw('COUNT(DISTINCT orders.id) as order_count'))
            ->groupBy('categories.id', 'categories.name')
            ->get();

        // return $orderCountByCategory;
        return Inertia::render('Admin/Index', [
            'orderCountByCategory' => $orderCountByCategory,
            'bestSellingProducts' => $bestSellingProducts,
            'categories' => $categories,
            'orderTotal' => $orderTotal,
            'productTotal' => $productTotal,
            'userTotal' => $userTotal
        ]);
    }
}
