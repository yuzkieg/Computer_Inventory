<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\OrderController; 
use App\Http\Controllers\ReportController;

// Authentication Routes
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Inventory Routes
Route::get('/order', [ProductController::class, 'order'])->name('order'); // Show order page
// or 
// Route::get('/order', [InventoryController::class, 'order'])->name('order');

Route::get('/supplier', [SupplierController::class, 'index'])->name('supplier');
Route::get('/reports', [InventoryController::class, 'reports'])->name('reports');
Route::get('/stockin', [InventoryController::class, 'stockin'])->name('stockin');
Route::get('/stockout', [InventoryController::class, 'stockout'])->name('stockout');
Route::get('/update_product', [InventoryController::class, 'update_product'])->name('update_product');

// Product Routes
Route::get('/stacks', [ProductController::class, 'index'])->name('stacks');
Route::post('/stacks', [ProductController::class, 'store'])->name('product.store');
Route::post('/stacks/{id}', [ProductController::class, 'restock'])->name('restock_product');
Route::get('/stockout', [ProductController::class, 'stockOut'])->name('stockout');

Route::get('/update_product/{id}', [ProductController::class, 'edit'])->name('edit_product'); 
Route::post('/update_product/{id}', [ProductController::class, 'update'])->name('update_product'); 
Route::delete('/remove-product/{id}', [ProductController::class, 'removeProduct'])->name('remove_product');

// Supplier Routes
Route::get('/supplier/create', [SupplierController::class, 'create'])->name('supplier.create');
Route::post('/supplier', [SupplierController::class, 'store'])->name('supplier.store');
Route::get('/supplier/{id}/edit', [SupplierController::class, 'edit'])->name('supplier.edit');
Route::put('/supplier/{id}', [SupplierController::class, 'update'])->name('supplier.update');
Route::delete('/supplier/{id}', [SupplierController::class, 'destroy'])->name('supplier.destroy');

// Order placement
Route::post('/place-order', [OrderController::class, 'placeOrder'])->name('place.order');

// Supplier's orders viewing and creation
Route::get('/supplier/{id}/orders', [SupplierController::class, 'showOrders'])->name('supplier.orders');
Route::post('/supplier/{id}/orders', [SupplierController::class, 'storeOrder'])->name('order.store');

// Correct route for marking order as received
Route::post('/orders/{id}/receive', [OrderController::class, 'markAsReceived'])->name('order.receive');
Route::post('/products/{id}/restock', [ProductController::class, 'restock'])->name('product.restock');

Route::post('/orders/{id}/receive', [OrderController::class, 'markAsReceivedAndUpdateStock'])->name('order.receive');
Route::get('/reports', [ReportController::class, 'index'])->name('reports');



// Route to handle storing new product (this is the one your form posts to)
Route::post('/products', [ProductController::class, 'store'])->name('products.store');

// Route for stockout and other actions, if needed
// For example:
Route::get('/stockout', [ProductController::class, 'stockOut'])->name('stockout');
