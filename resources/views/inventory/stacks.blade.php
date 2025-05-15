<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Stocks</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" />
    <style>
        body {
            background: url('{{ asset('images/background_image.png') }}') no-repeat center center fixed;
            background-size: cover;
            color: white;
            overflow-x: hidden;
        }

        .container {
            display: flex;
        }

        .sidebar {
            width: 250px;
            background-color: #333;
            padding: 20px;
            position: fixed;
            height: 100%;
            left: 0;
        }

        .sidebar h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .nav-link {
            color: white;
            font-size: 18px;
            margin: 10px 0;
            display: block;
            text-decoration: none;
            transition: 0.3s;
        }

        .nav-link:hover {
            background-color: #444;
            border-radius: 5px;
            padding: 10px;
        }

        .nav-link.active {
            background-color: #555; /* Highlight color for the active link */
        }

        .main-content {
            margin-left: 180px;
            padding: 20px;
            flex-grow: 2;
        }

        .logo {
            width: 180px;
            margin-bottom: 20px;
        }

        .search-bar {
            width: 50%;  
            padding: 10px;  
            border-radius: 20px;  
            border: none;  
            text-align: left;  
            margin: 10px 0;  
        }

        table {
            width: 100%; 
            background: rgba(0, 0, 0, 0.7); 
            color: white; 
            border-collapse: collapse; 
        }

        table th, table td {
            padding: 10px; 
            border: 1px solid white; 
            text-align: center; 
        }

        thead {
            margin-top: 0;
            position: sticky; 
            top: 0; 
            background: #333;
            color: white;
        }

        th {
            padding: 0;
        }

        .btn-custom {
            display: inline-flex; 
            align-items: center; 
            justify-content: center; 
            padding: 10px 20px; 
            font-size: 16px; 
            font-weight: bold; 
            border-radius: 10px; 
            text-decoration: none; 
            transition: 0.3s; 
            color: white; 
            border: none; 
        }

        .btn-logout {
            position: absolute;
            bottom: 20px;
            left: 20px;
            background-color: #d90429;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 5px;
            text-decoration: none;
        }
        .btn-logout:hover {
            background-color: #660313;
        }

        /* Button styles for different actions */
        .btn-stock-in { background-color: #2d6a4f; }
        .btn-stock-in:hover { background-color: #1b4332; }
        
        .btn-update { background-color: #c49b06; }
        .btn-update:hover { background-color: #a78504; }

        .btn-remove { background-color: #8b4d4d; }
        .btn-remove:hover { background-color: #6a3a3a; }

        .btn-stock-out {
            background-color: #ba181b; 
        }
        .btn-stock-out:hover { background-color: #920f12; } 

        /* Remove hover effect on Restock buttons */
        .btn-success:hover {
            background-color: #037a2a !important;
            color: white !important;
        }

        /* Style for dropdown items with hover effect */
        .dropdown-item:hover {
            background-color: #a0a0a0; /* Light background on hover */
            color: #000; /* Optional: change text color on hover */
        }

        /* Optional: style to remove borders or backgrounds from the inline buttons inside dropdowns */
        .dropdown-item.d-flex.align-items-center {
            border: none;
            background: none;
            padding: 8px 16px;
        }

        /* Ensure icons and text are aligned properly inside dropdown items */
        .dropdown-item i {
            margin-right: 8px;
        }

        .bottom-buttons {
            display: flex; 
            justify-content: space-between; 
            margin-top: 10px; 
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <img src="images/image.png" alt="Logo" class="logo" />
            <h1>Inventory System</h1>
            <a href="{{ route('order') }}" class="nav-link">Place Order</a>
            <a href="{{ route('stacks') }}" class="nav-link {{ Route::is('stacks') ? 'active' : '' }}">Stocks</a>
            <a href="{{ route('supplier') }}" class="nav-link {{ Route::is('supplier') ? 'active' : '' }}">Supplier</a>
            <a href="{{ route('reports') }}" class="nav-link {{ Route::is('reports') ? 'active' : '' }}">Reports</a>
            <a href="{{ route('login') }}" class="btn-logout"><i class="bi bi-box-arrow-right"></i> Log out</a>
        </div>
        
        <div class="main-content">
            <h2>Stocks</h2>
            <input type="text" id="search-bar" class="search-bar" placeholder="Search" />

            <!-- Alert for low stock products -->
            @php
                $lowStockProducts = $products->filter(function($product) {
                    return $product->quantity <= 10;
                });
            @endphp

            @if ($lowStockProducts->count() > 0)
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Warning!</strong> The following products are low in stock:
                    <ul>
                        @foreach ($lowStockProducts as $lowStockProduct)
                            <li style="display: flex; align-items: center; justify-content: space-between;">
                                {{ $lowStockProduct->name }} - Quantity: {{ $lowStockProduct->quantity }}
                                <form action="{{ route('order.store', $lowStockProduct->supplier->id) }}" method="POST" style="margin-left: 10px;">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $lowStockProduct->id }}">
                                    <input type="hidden" name="quantity" value="20" />
                                    <button type="submit" class="btn btn-link p-0 m-0" style="vertical-align: middle;">Restock</button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif


 

            <!-- Table container -->
            <div style="position: relative; height: 400px; overflow-y: auto; border: 1px solid #000; border-radius: 10px; background: rgba(0, 0, 0, 0.7); padding: 10px; margin-top: 20px;">
                <table id="products-table" style="width: 100%; border-collapse: collapse; border: 1px solid white;">
                    <thead style="position: sticky; top: 0; background: #333; color: white;">
                        <tr>
                            <th style="text-align: center; padding: 10px; border: 1px solid white;">Product Name</th>
                            <th style="text-align: center; padding: 10px; border: 1px solid white;">Quantity</th>
                            <th style="text-align: center; padding: 10px; border: 1px solid white;">Price</th>
                            <th style="text-align: center; padding: 10px; border: 1px solid white;">Serial Number</th>
                            <th style="text-align: center; padding: 10px; border: 1px solid white;">Supplier</th>
                            <th style="text-align: center; padding: 10px; border: 1px solid white;">Product Lifespan</th>
                            <th style="text-align: center; padding: 10px; border: 1px solid white;">Supplier Warranty</th>
                            <th style="text-align: center; padding: 10px; border: 1px solid white;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td style="text-align: center; padding: 10px; border: 1px solid white;">{{ $product->name }}</td>
                                <td style="text-align: center; padding: 10px; border: 1px solid white;">{{ $product->quantity }}</td>
                                <td style="text-align: center; padding: 10px; border: 1px solid white;">₱{{ $product->price }}</td>
                                <td style="text-align: center; padding: 10px; border: 1px solid white;">{{ $product->serial_number }}</td>
                                <td style="text-align: center; padding: 10px; border: 1px solid white;">{{ $product->supplier->supplier_name }}</td>
                                <td style="text-align: center; padding: 10px; border: 1px solid white;">{{ $product->product_lifespan ?? 'N/A' }}</td>
                                <td style="text-align: center; padding: 10px; border: 1px solid white;">{{ $product->supplier_warranty ?? 'N/A' }}</td>
                                <td>
                                    <!-- Existing dropdown actions -->
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="actionsDropdown{{ $product->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                            Actions
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="actionsDropdown{{ $product->id }}">
                                            <li>
                                                <a class="dropdown-item text-warning" href="{{ route('update_product', $product->id) }}">
                                                    <i class="bi bi-pencil-square"></i> Edit
                                                </a>
                                            </li>
                                            <li>
                                                <form action="{{ route('remove_product', $product->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <input type="hidden" name="_method" value="DELETE" />
                                                    <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to remove this product?')">
                                                        <i class="bi bi-trash"></i> Remove
                                                    </button>
                                                </form>
                                            </li>
                                            <li>
                                                <form action="{{ route('order.store', $product->supplier->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $product->id }}" />
                                                    <input type="hidden" name="quantity" value="20" />
                                                    <button type="submit" class="dropdown-item text-success d-flex align-items-center" title="Restock 20 units" style="border: none; background: none;">
                                                        <i class="bi bi-plus-lg me-2"></i> Restock
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Bottom Buttons: Stock In and Stock Out -->
            <div class="bottom-buttons">
                
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addProductModal">
                Add New Product <i class="bi bi-plus-circle"></i>
            </button>
                <a href="{{ route('stockin') }}" class="btn btn-primary">Stock In <i class="bi bi-plus-circle"></i></a>
                <a href="{{ route('stockout') }}" class="btn btn-danger">Stock Out <i class="bi bi-box-arrow-up"></i></a>
            </div>
        </div>
    </div>

    <!-- Add New Product Modal -->
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content bg-dark text-white">
          <div class="modal-header">
            <h5 class="modal-title" id="addProductModalLabel">Add New Product</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <!-- Your form for adding a new product -->
            <form action="{{ route(name: 'product.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="product_name" class="form-label">Product Name:</label>
                <input type="text" class="form-control" id="product_name" name="product_name" required>
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity:</label>
                <input type="number" class="form-control" id="quantity" name="quantity" required>
            </div>
            <div class="mb-3">
                <label for="serial_number" class="form-label">Serial Number:</label>
                <input type="text" class="form-control" id="serial_number" name="serial_number" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price:</label>
                <input type="text" class="form-control" id="price" name="price" required>
            </div>
            <div class="mb-3">
                <label for="supplier" class="form-label">Supplier:</label>
                <select class="form-select" id="supplier" name="supplier" required>
                    <option value="">Select Supplier</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->supplier_name }}">{{ $supplier->supplier_name }}</option>
                    @endforeach
                </select>
            </div>
              <!-- Additional fields -->
              <div class="mb-3">
                <label for="productLifespan" class="form-label">Product Lifespan</label>
                <input type="text" class="form-control" id="productLifespan" name="product_lifespan" placeholder="e.g., 2 years">
              </div>
              <div class="mb-3">
                <label for="supplierWarranty" class="form-label">Supplier Warranty</label>
                <input type="text" class="form-control" id="supplierWarranty" name="supplier_warranty" placeholder="e.g., 1 year">
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Add Product</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script>
        const searchBar = document.getElementById('search-bar');
        const table = document.getElementById('products-table');
        const rows = table.rows;

        searchBar.addEventListener('input', () => {
            const searchValue = searchBar.value.toLowerCase();

            for (let i = 1; i < rows.length; i++) {
                const row = rows[i];
                const productName = row.cells[0].textContent.toLowerCase();
                const serialNumber = row.cells[3].textContent.toLowerCase();
                const supplier = row.cells[4].textContent.toLowerCase();

                if (productName.includes(searchValue) || serialNumber.includes(searchValue) || supplier.includes(searchValue)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        });
    </script>
</body>
</html>