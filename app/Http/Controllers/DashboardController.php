<?php

namespace App\Http\Controllers;

use App\Models\CheckOut;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    function index()
    {
        $topProducts = Product::whereNotNull('credit')
            ->where('credit', '>', 0)
            ->orderBy('credit', 'desc')
            ->orderBy('updated_at', 'desc')  // Secondary sorting by latest created
            ->take(10)
            ->get();
        // dd($topProducts->toArray());
        $user_id = Auth::id();
        $check_outs = CheckOut::whereJsonContains('check_out->user_id', $user_id)->get();

        $monthlySales = [];

        foreach ($check_outs as $check_out) {
            $check_out_data = $check_out->check_out;
            if (isset($check_out_data['products'])) {
                foreach ($check_out_data['products'] as $product) {
                    if (isset($product['sold_at']) && isset($product['quantity'])) {
                        $sold_at = Carbon::parse($product['sold_at']);
                        $month = $sold_at->format('F Y'); // Use full month name and year
                        if (!isset($monthlySales[$month])) {
                            $monthlySales[$month] = 0;
                        }
                        $monthlySales[$month] += $product['quantity'];
                    }
                }
            }
        }

        $months = array_keys($monthlySales);
        $quantities = array_values($monthlySales);

        return view('dashboard.index', compact('topProducts', 'months', 'quantities'));
        // return view('dashboard.index', compact(''));
    }

    function fetchMonthlyProfit(Request $request)
    {
    }
}
