<?php

namespace App\Http\Controllers\Dashboard;

use Carbon\Carbon;
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
        $orders = Order::with(['order_details.user'])
            ->when($request->q, function ($query, $q) {
                $query->where('orders.invoice', 'like', '%' . $q . '%')
                    ->orWhereHas('order_details.user', function ($subQuery) use ($q) {
                        $subQuery->where('name', 'like', '%' . $q . '%');
                    });
            })->latest()->paginate(10);

        foreach ($orders as $data) {
            $data->total = currencyFormat($data->total);
            $data->amount = currencyFormat($data->amount);
            $data->status = statusToString($data->status);
            $data->formatted_date = Carbon::parse($data->created_at)->translatedFormat('d F Y');
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
        $order = Order::select('id', 'invoice', 'amount', 'total', 'status')
            ->with(['order_details.user'])
            ->with([
                'order_products' => function ($query) {
                    $query->select(
                        'order_id',
                        'product_id',
                        'qty',
                        'unit_price',
                        DB::raw('(qty * unit_price) as total_price')
                    );
                },
                'order_products.product' => function ($query) {
                    $query->select('id', 'name', 'price');
                }
            ])->findOrFail($id);

        $order->status = statusToString($order->status);
        $order->formatted_date = Carbon::parse($order->created_at)->translatedFormat('d F Y');
        return Inertia::render('Admin/Order/Edit', [
            'order' => $order
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $order = $order = Order::with(['order_products.product', 'order_details.user'])
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
