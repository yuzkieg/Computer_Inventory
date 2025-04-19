<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\OrderController; 


// Authentication Routes
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Inventory Routes
// Choose one of these routes for the order
Route::get('/order', [ProductController::class, 'order'])->name('order'); // assuming you want to show products here
// or 
// Route::get('/order', [InventoryController::class, 'order'])->name('order'); // if you want to show inventory order

Route::get('/supplier', [SupplierController::class, 'index'])->name('supplier');
Route::get('/reports', [InventoryController::class, 'reports'])->name('reports');
Route::get('/stockin', [InventoryController::class, 'stockin'])->name('stockin');
Route::get('/stockout', [InventoryController::class, 'stockout'])->name('stockout');
// Ensure this route works as intended in InventoryController
Route::get('/update_product', [InventoryController::class, 'update_product'])->name('update_product');

// Product Routes
Route::get('/stacks', [ProductController::class, 'index'])->name('stacks');
Route::post('/stacks', [ProductController::class, 'store'])->name('product.store');
Route::post('/stacks/{id}', [ProductController::class, 'restock'])->name('restock_product');
Route::get('/stockout', [ProductController::class, 'stockOut'])->name('stockout');

// Route for showing the edit form
Route::get('/update_product/{id}', [ProductController::class, 'edit'])->name('edit_product'); 
Route::post('/update_product/{id}', [ProductController::class, 'update'])->name('update_product'); 
Route::delete('/remove-product/{id}', [ProductController::class, 'removeProduct'])->name('remove_product');

// Supplier Routes
Route::get('/supplier/create', [SupplierController::class, 'create'])->name('supplier.create');
Route::post('/supplier', [SupplierController::class, 'store'])->name('supplier.store');
Route::get('/supplier/{id}/edit', [SupplierController::class, 'edit'])->name('supplier.edit');
Route::put('/supplier/{id}', [SupplierController::class, 'update'])->name('supplier.update');
Route::delete('/supplier/{id}', [SupplierController::class, 'destroy'])->name('supplier.destroy');

Route::post('/place-order', [OrderController::class, 'placeOrder'])->name('place.order');
