<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Method to place an order
    public function placeOrder(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'orders' => 'required|array',
            'totalAmount' => 'required|numeric',
        ]);
    
        // Get the orders from the request
        $orderData = $request->input('orders');
    
        foreach ($orderData as $order) {
            // Create a new transaction entry for each item
            $transaction = new Transaction();
            $transaction->item_name = $order['name']; // Set item name
            $transaction->quantity = $order['qty']; // Set quantity
            $transaction->price_each = $order['price']; // Set price per item
            $transaction->total_price = $order['price'] * $order['qty']; // Calculate total price
            $transaction->save(); // Save the transaction
        }
    
        return response()->json(['message' => 'Order placed successfully!']);
    }
}