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
        $categories = Category::get();
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
            'categories' => $categories,
        ]);
    }

    public function users()
    {
        $users = User::all();
        return Inertia::render('Admin/User/Index', ['users' => $users]);
    }
}
