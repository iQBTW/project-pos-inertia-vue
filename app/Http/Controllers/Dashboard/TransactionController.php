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

        foreach ($products as $product) {
            $product->price = number_format($product->price, 0, '.', '');
        }

        return Inertia::render('Admin/Transaction/Index', [
            'products' => $products,
        ]);

    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $validated = $request->validate([
            'invoice' => 'required',
            'user_id' => 'required|exists:users,id',
            'inputs.*.amount' => 'required|numeric',
            'inputs.*.product_id' => 'required|exists:products,id',
            'inputs.*.qty' => 'required|numeric'
        ]);

        DB::beginTransaction();

        try {
            foreach ($validated['inputs'] as $input) {
                $product = Product::find($input['product_id']);
                if (!$product) {
                    throw new \Exception('Product not found.');
                    if ($product->stock < $input['qty']) {
                        return back()->with('error', 'Product ' . $product->name . ' is out of stock');
                    }
                }

                $totalPrice = $product->price * $input['qty'];

                $order = Order::create([
                    'invoice' => invoiceNumber(),
                    'user_id' => $user->id,
                    'amount' => $input['amount'],
                    'status' => $input['amount'] ? 0 : 1,
                ]);

                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $input['product_id'],
                    'qty' => $input['qty'],
                    'total' => $totalPrice,
                ]);
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
