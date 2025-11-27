<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\SystemLog;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Product::class, 'product');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::latest()->get();
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:products,title',
            'is_active' => 'boolean',
        ]);

        $product = Product::create([
            'title' => $validated['title'],
            'is_active' => $request->has('is_active') ? true : false,
            // unique_id will be auto-generated in the model
        ]);

        SystemLog::record('product_created', [
            'summary' => "Created product {$product->title}",
            'product_id' => $product->id,
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:products,title,' . $product->id,
            'is_active' => 'boolean',
        ]);

        $product->update([
            'title' => $validated['title'],
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        SystemLog::record('product_updated', [
            'summary' => "Updated product {$product->title}",
            'product_id' => $product->id,
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        SystemLog::record('product_deleted', [
            'summary' => "Deleted product {$product->title}",
            'product_id' => $product->id,
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
