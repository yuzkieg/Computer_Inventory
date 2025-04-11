<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::all();
        return view('inventory.supplier', ['suppliers' => $suppliers]);
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
}