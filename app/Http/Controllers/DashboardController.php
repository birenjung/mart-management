<?php

namespace App\Http\Controllers;

use App\Models\CheckOut;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{


    public function index()
    {
        // Fetch top 10 products by credit, ordered by updated_at if credits are equal
        $topProducts = Product::whereNotNull('credit')
            ->where('credit', '>', 0)
            ->orderBy('credit', 'desc')
            ->orderBy('updated_at', 'desc')
            ->take(10)
            ->get();

        $user_id = Auth::id();
        $check_outs = CheckOut::whereJsonContains('check_out->user_id', $user_id)->get();

        $monthlySales = [];
        $totalSales = 0;
        $totalCost = 0;

        foreach ($check_outs as $check_out) {
            $check_out_data = $check_out->check_out;  // Correctly decode JSON data
            if (isset($check_out_data['products'])) {
                foreach ($check_out_data['products'] as $product) {
                    if (isset($product['sold_at']) && isset($product['quantity']) && isset($product['product_id'])) {
                        // Calculate monthly sales
                        $sold_at = Carbon::parse($product['sold_at']);
                        $month = $sold_at->format('F Y'); // Use full month name and year
                        if (!isset($monthlySales[$month])) {
                            $monthlySales[$month] = 0;
                        }
                        $monthlySales[$month] += $product['quantity'];

                        // Calculate total sales
                        $productModel = Product::find($product['product_id']);
                        if ($productModel) {
                            $totalSales += $productModel->product_price * $productModel->credit;
                            $totalCost += $productModel->product_cost_price * $productModel->credit;
                        }
                    }
                }
            }
        }

        $months = array_keys($monthlySales);
        $quantities = array_values($monthlySales);

        // Example: Calculating total investment
        $products = Product::all();
        $total_investment = 0;
        foreach ($products as $item) {
            $total_investment += $item->product_cost_price * $item->product_stock;
        }

        return view('dashboard.index', compact('topProducts', 'months', 'quantities', 'totalSales', 'products', 'total_investment', 'totalCost'));
    }


    function fetchMonthlyProfit(Request $request)
    {
    }
}
