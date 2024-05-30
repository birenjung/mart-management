<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Checkout;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CheckOutController extends Controller
{
    public function checkOut(Request $request)
    {
        $user_id = Auth::id();
        $cart = Cart::whereJsonContains('cart_items->user_id', $user_id)->first();

        if ($cart) {
            $currentDate = Carbon::now()->toDateString();

            // Check if there's an existing checkout for the user today
            $checkout = Checkout::whereJsonContains('check_out->user_id', $user_id)
                ->whereJsonContains('check_out->products->1->sold_at', $currentDate)
                ->first();

            $cart_items = $cart->cart_items['products'];
            foreach ($cart_items as &$item) {
                $product = Product::find($item['product_id']);
                $product->credit = $item['quantity'];
                $product->save();
                $item['sold_at'] = Carbon::now()->toDateTimeString();
            }

            if ($checkout) {
                // If checkout exists, append new products to the existing products
                $existing_items = $checkout->check_out['products'];

                foreach ($cart_items as $item) {
                    // Generate a unique key for the new item
                    $new_index = count($existing_items) + 1;

                    // Ensure the new index is unique
                    while (isset($existing_items[$new_index])) {
                        $new_index++;
                    }

                    $existing_items[$new_index] = $item;
                }

                $checkout_items = $checkout->check_out;
                $checkout_items['products'] = $existing_items;
                $checkout->check_out = $checkout_items;
            } else {
                // If no checkout exists, create a new one
                $checkout = new Checkout();
                $checkout->check_out = [
                    "user_id" => $user_id,
                    "products" => $cart_items
                ];
            }

            $checkout->save();

            foreach ($cart_items as $item) {
                $product = Product::find($item['product_id']);
                if ($product) {
                    $product->product_stock -= $item['quantity'];
                    if ($product->product_stock <= 0) {
                        $product->delete();
                    } else {
                        $product->save();
                    }
                }
            }

            // Remove the cart after checkout
            $cart->delete();

            Alert::success('Success', 'Checkout successful.');
            return redirect()->route('cart');
        }

        Alert::info('Sorry, the cart is empty.');
        return redirect()->route('cart');
    }
}
