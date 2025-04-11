<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InventoryController extends Controller
{

    public function supplier()
    {
        return view('inventory.supplier'); // Ensure this view exists
    }

    public function reports()
    {
        return view('inventory.reports'); // Ensure this view exists
    }
    
    public function dashboard()
    {
        return view('inventory.dashboard'); // Ensure this view exists
    }
    
    public function stockin()
    {
        return view('inventory.stockin'); // Ensure this view exists
    }
    
    public function stockout()
    {
        return view('inventory.stockout'); // Ensure this view exists
    }

    public function register()
    {
        return view('inventory.register'); // Ensure this view exists
    }

    public function update_product()
    {
        return view('inventory.update_product'); // Ensure this view exists
    }
}