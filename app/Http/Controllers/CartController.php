<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class CartController extends Controller
{

    function index()
    {
        $user_id = Auth::id();
        $cart = Cart::whereJsonContains('cart_items->user_id', $user_id)->first();

        $grandTotal = 0;
        $cart_items = [];

        if ($cart && is_array($cart->cart_items['products'])) {
            $cart_items = $cart->cart_items;

            foreach ($cart_items['products'] as &$item) {
                $product = Product::find($item['product_id']);
                if ($product) {
                    $item['product'] = $product;
                    $grandTotal += $product->product_price * $item['quantity'];
                }
            }
        }

        return view('cart.index', compact('cart_items', 'grandTotal'));
    }


    function addToCart($product_id, $quantity = 1)
    {
        try {
            $user_id = auth()->id();
        $todayDateTime = Carbon::now();
        // Check if the user has an existing cart
        $cart = Cart::whereJsonContains('cart_items->user_id', $user_id)->first();

        if (empty($cart)) {
            // If the user doesn't have a cart, create a new one
            $cart = new Cart();
            $cart['cart_items'] = [
                "user_id" => $user_id,
                "products" => [
                    "1" => [
                        'product_id' => $product_id,
                        'quantity' => $quantity,

                    ]
                ]
            ];

            $cart->save();

            $product = Product::find($product_id);
            // Decrease the product stock by 1
            $product->product_stock -= 1;

            // Check if the stock is now 0
            if ($product->product_stock == 0) {
                // Delete the product if the stock is 0
                $product->delete();
            } else {
                // Save the updated product stock
                $product->save();
            }

            Alert::success('Success', 'The product is added to cart.');
            return back();
        } else {
            // If the user already has a cart, add the product to the existing cart
            $cart_items = $cart->cart_items;

            foreach ($cart_items['products'] as $key => $product) {
                if ($product['product_id'] == $product_id) {
                    // Product is already in the cart, return back
                    Alert::info('Sorry', 'The product is already added to cart.');
                    return back();
                }
            }

            // Check if the product already exists in the cart
            if (isset($cart_items['products'][$product_id])) {
                // If the product exists, increment its quantity
                $cart_items['products'][$product_id]['quantity'] += $quantity;
            } else {
                // If the product doesn't exist, add it to the cart with a new key
                $max_key = max(array_keys($cart_items['products'])) + 1;
                $cart_items['products'][$max_key] = [
                    "product_id" => $product_id,
                    "quantity" => $quantity,

                ];
            }

            $cart->cart_items = $cart_items;
            $cart->save();

            $product = Product::find($product_id);
            // Decrease the product stock by 1
            $product->product_stock -= 1;

            // Check if the stock is now 0
            if ($product->product_stock == 0) {
                // Delete the product if the stock is 0
                $product->delete();
            } else {
                // Save the updated product stock
                $product->save();
            }

            Alert::success('Success', 'The product is added to cart.');
            return back();
        }
        } catch (\Exception $th) {
            //throw $th;
            dd($th);
        }
    }


    
    private function updateProductStock($product_id, $quantity)
    {
        $product = Product::findOrFail($product_id);
        $product->product_stock -= $quantity;
    
        if ($product->product_stock <= 0) {
            $product->delete();
        } else {
            $product->save();
        }
    }

    public function quantityUpdate(Request $request)
    {
        $user_id = Auth::id();
        $product_id = $request->input('product_id');
        $quantity = $request->input('quantity');
        $product = Product::find($product_id);
        if ($quantity > $product->product_stock) {
            return response()->json([
                'status' => 100,
                'quantity' => $product->product_stock
            ]);
        }
        $newSubtotal = 0;
        $grandTotal = 0;

        $cart = Cart::whereJsonContains('cart_items->user_id', $user_id)->first();

        if ($cart) {
            $cart_items = $cart->cart_items;

            foreach ($cart_items['products'] as &$item) {
                $product = Product::find($item['product_id']);
                if ($item['product_id'] == $product_id) {
                    $item['quantity'] = $quantity;
                    $newSubtotal = $product->product_price * $quantity;
                }
                $grandTotal += $product->product_price * $item['quantity'];
            }

            $cart->cart_items = $cart_items;
            $cart->save();

            return response()->json([
                'success' => true,
                'newSubtotal' => $newSubtotal,
                'grandTotal' => $grandTotal,
            ]);
        }

        return response()->json(['success' => false]);
    }


    public function deleteCartItem($id)
    {
        $user_id = Auth::id();
        $cart = Cart::whereJsonContains('cart_items->user_id', $user_id)->first();
        $product = Product::find($id);

        if ($cart && $product) {
            $cart_items = $cart->cart_items;

            // Remove the product with the given product_id
            foreach ($cart_items['products'] as $key => $item) {
                if ($item['product_id'] == $id) {
                    // Increment product stock
                    $product->product_stock += $item['quantity'];
                    $product->save();

                    // Remove the item from the cart
                    unset($cart_items['products'][$key]);
                    break;
                }
            }

            if (empty($cart_items['products'])) {
                // If no products left in cart, delete the cart
                $cart->delete();
            } else {
                // Save the updated cart items back to the cart
                $cart->cart_items = $cart_items;
                $cart->save();
            }

            Alert::success('Success', 'The product has been removed from the cart successfully.');
        } else {
            Alert::error('Error', 'Product not found or cart is empty.');
        }

        return back();
    }

}
