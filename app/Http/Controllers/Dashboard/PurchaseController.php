<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\OrderProduct;
use Inertia\Inertia;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use PHPUnit\Framework\Exception;

class PurchaseController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $products = Product::with('product_images')
            ->when($request->q, function ($query, $q) {
                $query->where('products.name', 'like', '%' . $q . '%');
            })->paginate(5);

        foreach ($products as $product) {
            $product->price = number_format($product->price, 0, '.', '');
        }

        return Inertia::render('Admin/Purchase/Index', [
            'products' => $products,
            'user' => $user,
            'search' => $request->only('q'),
        ]);
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $validated = $request->validate([
            'cart' => 'required|array',
            'user_id' => 'required|exists:users,id',
            'cart.*.product_id' => 'required|exists:products,id',
            'cart.*.qty' => 'required|numeric',
            'cart.*.unit_price' => 'required|numeric',
            'address' => 'required|string',
            'amount' => 'required|numeric',
            'total' => 'required|numeric',
        ]);

        DB::beginTransaction();

        try {
            if ($validated['cart'] < 1) {
                return back()->with('error', 'Cart is empty!');
            }

            $order = Order::create([
                'invoice' => invoiceNumber(),
                'amount' => $validated['amount'],
                'total' => $validated['total'],
                'status' => 1,
            ]);

            OrderDetail::create([
                'user_id' => $user->id,
                'order_id' => $order->id,
                'address' => $validated['address'],
            ]);

            foreach ($validated['cart'] as $item) {
                $product = Product::find($item['product_id']);

                if (!$product) {
                    return back()->with('error', 'Product not found!');
                    if ($product->stock < $item['qty']) {
                        return back()->with('error', 'Product ' . $product->name . ' is out of stock');
                    }
                }

                OrderProduct::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'qty' => $item['qty'],
                    'unit_price' => $product->price,
                ]);

                $product->stock -= $item['qty'];
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
