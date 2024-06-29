<?php

namespace App\Http\Controllers\Dashboard;

use Inertia\Inertia;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $orders = Order::select(
            'orders.*',
            'users.name as customer',
            'products.name as product',
            'order_details.qty as qty',
            'order_details.total as total'
        )
            ->join('order_details', 'order_details.order_id', '=', 'orders.id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->when($request->q, function ($query, $q) {
                $query->where('users.name', 'like', '%' . $q . '%');
                $query->orWhere('products.name', 'like', '%' . $q . '%');
            })
            ->paginate(10);

        foreach ($orders as $data) {
            $data->total = currencyFormat($data->total);
            $data->amount = currencyFormat($data->amount);
        }

        return Inertia::render('Admin/Order/Index', [
            'orders' => $orders,
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
    public function store(StoreOrderRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
