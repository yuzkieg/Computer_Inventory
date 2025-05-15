<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InventoryReport; // assuming you have a model for inventory_reports

class ReportController extends Controller
{
    public function index()
    {
        // Fetch all reports from the database
        $reports = InventoryReport::all();

        // Optionally, calculate total inventory value or other aggregates
        $totalInventoryValue = $reports->sum('inventory_value');

        // Pass data to the view
        return view('inventory.reports', compact('reports', 'totalInventoryValue'));
    }
}