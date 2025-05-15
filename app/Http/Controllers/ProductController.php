<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Supplier;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('supplier')->get();
        return view('inventory.stacks', compact('products'));
    }

public function stockin()
{
    $suppliers = Supplier::all();
    return view('inventory.stockin', compact('suppliers'));
}

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required',
            'quantity' => 'required|integer',
            'serial_number' => 'required',
            'price' => 'required|numeric',
            'supplier' => 'required',
        ]);

        $supplier = Supplier::where('supplier_name', $request->input('supplier'))->first();
        if (!$supplier) {
            return redirect()->back()->withErrors(['supplier' => 'Supplier not found.']);
        }

        $product = new Product();
        $product->name = $request->input('product_name');
        $product->quantity = $request->input('quantity');
        $product->serial_number = $request->input('serial_number');
        $product->price = $request->input('price');
        $product->supplier_id = $supplier->id;

        $product->save();
        return redirect()->route('stockin')->with('success', 'Product created successfully');
    }

    public function removeProduct(Request $request, $id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->delete();
            return redirect()->back()->with('success', 'Product removed successfully.');
        } else {
            return redirect()->back()->with('error', 'Product not found.');
        }
    }

    public function edit($id)
    {
        $product = Product::with('supplier')->findOrFail($id);
        $suppliers = Supplier::all();
        return view('inventory.update_product', compact('product', 'suppliers'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'product_name' => 'required',
            'quantity' => 'required|integer',
            'serial_number' => 'required',
            'price' => 'required|numeric',
            'supplier' => 'required',
        ]);

        $product = Product::findOrFail($id);
        $supplier = Supplier::where('supplier_name', $request->input('supplier'))->first();
        if (!$supplier) {
            return redirect()->back()->withErrors(['supplier' => 'Supplier not found.']);
        }

        // Update the product fields
        $product->name = $request->input('product_name');
        $product->quantity = $request->input('quantity');
        $product->serial_number = $request->input('serial_number');
        $product->price = $request->input('price');
        $product->supplier_id = $supplier->id;

        $product->save();

        return redirect()->route('stacks')->with('success', 'Product updated successfully');
    }

    public function restock(Request $request, $id)
    {
        // Validate that 'quantity' is present and is an integer
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);
    
        $product = Product::findOrFail($id);
    
        // Add the input quantity to the existing quantity
        $product->quantity += $request->input('quantity');
        $product->save();
    
        return redirect()->route('stacks')->with('success', 'Product restocked successfully!');
    }
    public function stockOut()
    {
        // Fetching products with zero quantity
        $products = Product::with('supplier')->where('quantity', 0)->get();
        return view('inventory.stockout', compact('products'));
    }
    public function order()
    {
        // Fetch all products from the database
        $products = Product::all();
        
        // Return the order view with the products, fixing the path
        return view('inventory.order', compact('products'));
    }

}