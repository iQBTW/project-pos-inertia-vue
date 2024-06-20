<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\OrderDetail;
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

        $bestSellingProduct = OrderDetail::select(
            'products.id as product_id',
            'products.name as product',
            'product_images.image as image',
            DB::raw('COUNT(order_details.id) as order_count')
        )
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->leftjoin('product_images', 'products.id', '=', 'product_images.product_id')
            ->groupBy('products.id', 'products.name', 'product_images.image')
            ->orderBy('order_count', 'desc')
            ->get();

        $orderByCategory = OrderDetail::select(
            'categories.id as category_id',
            'categories.name as category',
            DB::raw('COUNT(order_details.id) as order_count')
        )
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->rightjoin('categories', 'products.category_id', '=', 'categories.id')
            ->groupBy('categories.id', 'categories.name')
            ->orderBy('order_count', 'desc')
            ->get();

        return Inertia::render('Admin/Home', [
            'orderByCategory' => $orderByCategory,
            'bestSellingProduct' => $bestSellingProduct,
            'categories' => $categories,
            'orderTotal' => $orderTotal,
            'productTotal' => $productTotal,
            'userTotal' => $userTotal
        ]);
    }
}
