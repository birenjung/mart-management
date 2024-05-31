<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        foreach($products as $item) {
            $productCategory = ProductCategory::find($item->product_category);
            $item->category = $productCategory->category_name;
        }
        return view('product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ProductCategory::where('category_status', 'active')->get();
        return view('product.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    { 
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'product_name' => 'required|string',
                'product_sku' => 'required|string',
                'product_price' => 'required|string',
                'product_stock' => 'required|string',
                'product_category' => 'required|numeric',
                'product_image' => 'nullable|image',
                'product_cost_price' => 'required|string',
            ]);

            // Create a new product instance
            $product = new Product();
            $product->product_name = $validatedData['product_name'];
            $product->product_sku = $validatedData['product_sku'];
            $product->product_price = $validatedData['product_price'];
            $product->product_cost_price = $validatedData['product_cost_price'];
            $product->product_stock = $validatedData['product_stock'];
            $product->product_category = $validatedData['product_category'];

            // Check if a file was uploaded
            if ($request->hasFile('product_image')) {
                $file = $request->file('product_image');
                // Generate a unique filename
                $filename = time() . '_' . $file->getClientOriginalName();
                // Move the file to the desired location
                $file->move('image/products/', $filename);
                // Store the file path in the database
                $product->product_image = 'image/products/' . $filename;                                
            }

            // Save the product
            $product->save();

            Alert::success('Success', 'Product created successfully.');

            // Redirect back with success message
            return back();
        } catch (\Exception $exception) {
            dd($exception);
            Alert::error('Error', 'Error while creating product.');
            // Handle any exceptions
            return back();
        }
    }





    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = ProductCategory::where('category_status', 'active')->get();
        return view('product.edit', compact('categories', 'product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'product_name' => 'required|string',
                'product_sku' => 'required|string',
                'product_price' => 'required|string',
                'product_stock' => 'required|string',
                'product_category' => 'required|numeric',
                'product_image' => 'nullable|image', // Assuming you're uploading image files
                 'product_cost_price' => 'required|string',
            ]);            
           
            $product->product_name = $validatedData['product_name'];
            $product->product_sku = $validatedData['product_sku'];
            $product->product_price = $validatedData['product_price'];
            $product->product_cost_price = $validatedData['product_cost_price'];
            $product->product_stock = $validatedData['product_stock'];
            $product->product_category = $validatedData['product_category'];

            // Check if a file was uploaded
            if ($request->hasFile('product_image')) {
                $file = $request->file('product_image');
                // Generate a unique filename
                $filename = time() . '_' . $file->getClientOriginalName();
                // Move the file to the desired location
                $file->move('image/products/', $filename);
                // Store the file path in the database
                $product->product_image = 'image/products/' . $filename;                                
            }

            // Save the product
            $product->update();

            Alert::success('Success', 'Product updated successfully.');

            // Redirect back with success message
            return back();
        } catch (\Exception $exception) {
            // dd($exception);
            Alert::error('Error', 'Error while updating product.');
            // Handle any exceptions
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        Alert::success('Success', 'The product is deleted successfully.');
        return redirect()->route('products.index');
    }
}
