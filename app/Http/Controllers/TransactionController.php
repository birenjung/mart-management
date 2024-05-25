<?php

namespace App\Http\Controllers;

use App\Models\CheckOut;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $user_id = Auth::id();
        $transactions = CheckOut::whereJsonContains('check_out->user_id', $user_id)->get();

        foreach ($transactions as $transaction) {
            $check_out = $transaction->check_out;
            foreach ($check_out['products'] as &$item) {
                $product = Product::find($item['product_id']);
                $item['product_name'] = $product ? $product->product_name : 'Unknown Product';
            }
            $transaction->check_out = $check_out;
        }

        // dd($transactions->toArray());
        return view('transaction.index', compact('transactions'));
    }

    function search(Request $request)
    {
        $user_id = Auth::id();
        $date = $request->input('date');
        $formattedDate = Carbon::parse($date)->toDateString();

        // Fetch transactions for the given date
        $transactions = CheckOut::whereJsonContains('check_out->user_id', $user_id)
            ->get()
            ->filter(function ($transaction) use ($formattedDate) {
                foreach ($transaction->check_out['products'] as $item) {
                    if (Carbon::parse($item['sold_at'])->toDateString() == $formattedDate) {
                        return true;
                    }
                }
                return false;
            });

        // Convert product IDs to product names
        foreach ($transactions as $transaction) {
            $check_out = $transaction->check_out;
            foreach ($check_out['products'] as &$item) {
                $product = Product::find($item['product_id']);
                $item['product_name'] = $product ? $product->product_name : 'Unknown Product';
            }
            $transaction->check_out = $check_out;
        }

        // dd($transactions->toArray());

        return view('transaction.index', compact('transactions'));
    }
}
