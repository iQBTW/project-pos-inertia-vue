<?php

namespace App\Http\Controllers\Dashboard;

use Inertia\Inertia;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class TransactionController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return Inertia::render('Admin/Transaction/Index', [
            'products' => $products,
        ]);
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric'
        ]);

        DB::beginTransaction();

        try {
            if ($request->has('product_id')) {
                $product = Product::find($request->product_id);
                foreach ($product as $item) {
                    Order::create([
                        'invoice' => '',
                        'user_id' => $user->id,
                        'product_id' => $validated['product_id'],
                    ]);
                }
            }
        }
        catch (\Throwable $e) {
            DB::rollBack();

            return back()->with('error', $e->getMessage());
        }
    }
}
