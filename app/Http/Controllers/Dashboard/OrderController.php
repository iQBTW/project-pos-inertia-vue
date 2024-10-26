<?php

namespace App\Http\Controllers\Dashboard;

use DB;
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
            })->latest()->paginate(10);

        foreach ($orders as $data) {
            $data->total = currencyFormat($data->total);
            $data->amount = currencyFormat($data->amount);
        }

        return Inertia::render('Admin/Order/Index', [
            'orders' => $orders,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $order = Order::select(
            'orders.*',
            'users.id as user_id',
            'users.name as user',
            'products.id as product_id',
            'products.name as product',
            'order_details.id as order_detail_id',
            'order_details.qty as qty',
            'order_details.total as total'
        )
            ->join('order_details', 'order_details.order_id', '=', 'orders.id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->findOrFail($id);

        $order->status = statusToString($order->status);

        return Inertia::render('Admin/Order/Edit', [
            'order' => $order
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $order = Order::select(
            'orders.*',
            'users.id as user_id',
            'users.name as user',
            'products.id as product_id',
            'products.name as product',
            'order_details.id as order_detail_id',
            'order_details.qty as qty',
            'order_details.total as total'
        )
            ->join('order_details', 'order_details.order_id', '=', 'orders.id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->findOrFail($id);

        $validated = $request->validate([
            'amount' => 'required|numeric',
        ]);

        DB::beginTransaction();

        try {
            if ($validated['amount'] < $order->total) {
                $order->update([
                    'amount' => $order->amount,
                    'status' => $order->status,
                ]);

                return redirect()->route('order.edit', $id)->with('error', 'Amount must be greater than total');
            }

            $order->update([
                'amount' => $validated['amount'],
                'status' => 1,
            ]);

            DB::commit();
            return redirect()->route('order.edit', $id)->with('success', 'Order has been updated succesfully');
        }
        catch (\Throwable $e) {
            DB::rollback();

            return redirect()->back()->with('error', $e->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $order = Order::where('id', $id)->delete();

        if ($order) {
            return redirect(route('order.index'))->with('success', 'Order has been deleted');
        }
        else {
            return redirect(route('order.index'))->with('error', 'Something went wrong');

        }
    }
}
