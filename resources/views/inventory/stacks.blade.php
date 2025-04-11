<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stacks</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
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
            transition: 0.3s;
        }
        .btn-logout:hover {
            background-color: #660313;
        }

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
            <img src="images/image.png" alt="Logo" class="logo">
            <h1>Inventory System</h1>
            <a href="{{ route('dashboard') }}" class="nav-link">Place Order</a>
            <a href="{{ route('stacks') }}" class="nav-link {{ Route::is('stacks') ? 'active' : '' }}">Stacks</a>
            <a href="{{ route('supplier') }}" class="nav-link {{ Route::is('supplier') ? 'active' : '' }}">Supplier</a>
            <a href="{{ route('reports') }}" class="nav-link {{ Route::is('reports') ? 'active' : '' }}">Reports</a>
            <a href="{{ route('login') }}" class="btn-logout btn-logout:hover"><i class="bi bi-box-arrow-right"></i> Log out</a>
        </div>
        
        <div class="main-content">
            <h2>Stacks</h2>
            <input type="text" id="search-bar" class="search-bar" placeholder="Search">
        
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
                            <li>
                                {{ $lowStockProduct->name }} - Quantity: {{ $lowStockProduct->quantity }}
                                <span class="float-end">
                                    <form action="{{ route('restock_product', $lowStockProduct->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <input type="hidden" name="quantity" value="20">
                                        <button type="submit" class="btn btn-sm btn-primary">Restock</button>
                                    </form>
                                </span>
                            </li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        
            <div style="position: relative; height: 400px; overflow-y: auto; border: 1px solid #000; border-radius: 10px; background: rgba(0, 0, 0, 0.7); padding: 10px; margin-top: 20px;">
                <table id="products-table" style="width: 100%; border-collapse: collapse; border: 1px solid white;">
                    <thead style="position: sticky; top: 0; background: #333; color: white;">
                        <tr>
                            <th style="text-align: center; padding: 10px; border: 1px solid white;">Product Name</th>
                            <th style="text-align: center; padding: 10px; border: 1px solid white;">Quantity</th>
                            <th style="text-align: center; padding: 10px; border: 1px solid white;">Price</th>
                            <th style="text-align: center; padding: 10px; border: 1px solid white;">Serial Number</th>
                            <th style="text-align: center; padding: 10px; border: 1px solid white;">Supplier</th>
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
                                <td style="text-align: center; padding: 10px; border: 1px solid white;">
                                    <a href="{{ route('update_product', $product->id) }}" class="btn btn-sm btn-outline-warning">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                    <form action="{{ route('remove_product', $product->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <input type="hidden" name="_method" value="DELETE"> 
                                        <button type="submit" class="btn btn-sm btn-outline-danger my-2" onclick="return confirm('Are you sure you want to remove this product?')">
                                            <i class="bi bi-trash"></i> Remove
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="bottom-buttons">
                <a href="{{ route('stockin') }}" class="btn btn-success"> Stock In <i class="bi bi-plus-circle"></i></a>
                <a href="{{ route('stockout') }}" class="btn btn-danger">Stock Out <i class="bi bi-box-arrow-up"></i> </a>
            </div>
        </div>
    </div>

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
