<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = ProductCategory::all();
        return view('product-category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('product-category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:100'
        ]);

        $productCategory = new ProductCategory();
        $productCategory->category_name = $request->category_name;
        $productCategory->save();

        Alert::success('Success', 'A product category is added successfully.');
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductCategory $productCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductCategory $productCategory)
    {
        return view('product-category.edit', compact('productCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductCategory $productCategory)
    {
        $request->validate([
            'category_name' => 'required|string|max:100'
        ]);
        
        $productCategory->category_name = $request->category_name;
        $productCategory->save();

        Alert::success('Success', 'The product category is updated successfully.');
        return redirect()->route('product_category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductCategory $productCategory)
    {
        $productCategory->delete();
        Alert::success('Success', 'The product category is deleted successfully.');
        return redirect()->route('product_category.index');
    }
    public function status(Request $request, $id)
    {
        // Find the product category by ID
        $productCategory = ProductCategory::find($id);
    
        // Check if the product category exists
        if ($productCategory) {
            // Toggle the status
            $productCategory->category_status = $productCategory->category_status == 'active' ? 'inactive' : 'active';
            $productCategory->save();
    
            // Show success message
            Alert::success('Success', 'The status of the product category has been changed.');
    
            // Redirect back
            return back();
        }
    
        // If product category not found, show error message
        Alert::error('Error', 'Product category not found.');
        return back();
    }
}
