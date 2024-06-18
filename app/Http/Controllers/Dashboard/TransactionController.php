<?php

namespace App\Http\Controllers\Dashboard;

use Inertia\Inertia;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class TransactionController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $user = auth()->user();

        foreach ($products as $product) {
            $product->price = number_format($product->price, 0, '.', '');
        }

        return Inertia::render('Admin/Transaction/Index', [
            'products' => $products,
            'user' => $user
        ]);

    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'inputs.*.amount' => 'required|numeric',
            'inputs.*.product_id' => 'required|exists:products,id',
            'inputs.*.qty' => 'required|numeric'
        ]);

        DB::beginTransaction();

        try {
            foreach ($validated['inputs'] as $input) {
                $product = Product::find($input['product_id']);
                // if (!$product) {
                //     return back()->with('error', 'Product not found.');
                // }
                // else if ($product->stock < $input['qty']) {
                //     return back()->with('error', 'Product ' . $product->name . ' is out of stock');

                // }

                $totalPrice = $product->price * $input['qty'];

                $order = Order::create([
                    'invoice' => invoiceNumber(),
                    'amount' => $input['amount'],
                    'status' => 0,
                    'user_id' => $user->id,
                ]);

                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $input['product_id'],
                    'qty' => $input['qty'],
                    'total' => $totalPrice,
                ]);

                // dd($orderD, $order, $product->stock -= $input['qty'], $product->id);
                $product->stock -= $input['qty'];
                $product->save();
            }

            DB::commit();

            return redirect(route('transaction.index'))->with('success', 'Transaction created successfully');
        }
        catch (\Throwable $e) {
            DB::rollBack();

            return back()->with('error', $e->getMessage());
        }
    }
}
