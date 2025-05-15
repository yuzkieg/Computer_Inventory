<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\Order;
use App\Models\Product;


class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::with('orders')->get();
        $orders = Order::with('supplier')->get(); // fetch all orders with supplier info
        return view('inventory.supplier', [
            'suppliers' => $suppliers,
            'orders' => $orders,
        ]);
    }

    public function create()
    {
        return view('inventory.create-supplier');
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_name' => 'required|string|max:255',
            'supplier_no' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        $supplier = new Supplier();
        $supplier->supplier_name = $request->supplier_name;
        $supplier->supplier_no = $request->supplier_no;
        $supplier->location = $request->location;
        $supplier->save();

        return redirect()->route('supplier')->with('success', 'Supplier created successfully');
    }

    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('inventory.edit-supplier', ['supplier' => $supplier]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'supplier_name' => 'required|string|max:255',
            'supplier_no' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        $supplier = Supplier::findOrFail($id);
        $supplier->supplier_name = $request->supplier_name;
        $supplier->supplier_no = $request->supplier_no;
        $supplier->location = $request->location;
        $supplier->save();

        return redirect()->route('supplier')->with('success', 'Supplier updated successfully');
    }

    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        return redirect()->route('supplier')->with('success', 'Supplier deleted successfully');
    }

    public function showOrders($supplierId)
    {
        $supplier = Supplier::with('orders')->findOrFail($supplierId);
        $suppliers = Supplier::with('orders')->get(); // fetch all suppliers
        return view('inventory.supplier', ['suppliers' => $suppliers, 'selectedSupplier' => $supplier]);
    }

// To handle order creation (optional, if you want to add orders via a form)
public function storeOrder(Request $request, $supplierId)
{
    // Validate incoming data
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1',
    ]);

    // Find the product
    $product = Product::findOrFail($request->input('product_id'));

    // Create a new order
    Order::create([
        'supplier_id' => $supplierId,
        'product_id' => $product->id,
        'product_name' => $product->name,
        'quantity' => $request->input('quantity'),
        'status' => 'pending',
    ]);

    // Redirect back to supplier page with success message
    return redirect()->route('supplier')->with('success', 'Order added successfully');
}

// To mark an order as received
public function markAsReceived($orderId)
{
    $order = Order::findOrFail($orderId);
    $order->status = 'received';
    $order->save();

    return back()->with('success', 'Order marked as received');
}
}