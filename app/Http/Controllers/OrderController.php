<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Order;
use App\Models\Product;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        // Validate request data
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Find the product
        $product = Product::findOrFail($request->input('product_id'));

        // Get supplier ID, assuming you have it from request or context
        $supplierId = $request->input('supplier_id');

        // Create the order
        Order::create([
            'supplier_id' => $supplierId,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'quantity' => $request->input('quantity'),
            'status' => 'pending',
        ]);

        // Redirect or return response
        return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    }


    // Method to mark order as received
    public function markAsReceived($id)
    {
        $order = Order::findOrFail($id);
        // Update the order status or relevant field
        $order->status = 'received'; // or your status field
        $order->save();

        // Redirect back to the stacks view
        return redirect()->route('stacks')->with('success', 'Order marked as received.');
    }
    public function markAsReceivedAndUpdateStock($orderId)
    {
        $order = Order::findOrFail($orderId);
    
        if ($order->status == 'received') {
            return redirect()->back()->with('error', 'Order already marked as received.');
        }
    
        $product = Product::find($order->product_id);
        if (!$product) {
            return redirect()->back()->with('error', 'Associated product not found.');
        }
    
        // Add the order quantity to product stock
        $product->quantity += $order->quantity;
        $product->save();
    
        // Mark the order as received
        $order->status = 'received';
        $order->save();
    
        return redirect()->back()->with('success', 'Order marked as received and stock updated.');
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'orders' => 'required|array',
            'totalAmount' => 'required|numeric',
        ]);
    
        $orderData = $request->input('orders');
    
        foreach ($orderData as $order) {
            // Create a transaction for each order item
            $transaction = new Transaction();
            $transaction->item_name = $order['name'];
            $transaction->quantity = $order['qty'];
            $transaction->price_each = $order['price'];
            $transaction->total_price = $order['price'] * $order['qty'];
            $transaction->save();
    
            // Find the product by name
            $product = Product::where('name', $order['name'])->first();
    
            if ($product && $product->quantity >= $order['qty']) {
                // Deduct the ordered quantity from the product stock
                $product->quantity -= $order['qty'];
                $product->save();
            } else {
                // Handle insufficient stock
                return response()->json(['error' => 'Insufficient stock for ' . $order['name']], 400);
            }
        }
    
        return response()->json(['message' => 'Order placed successfully!']);
    }
    }