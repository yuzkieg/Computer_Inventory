<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Out Logging</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <style>
        body {
            background: url('images/background_image.png') no-repeat center center fixed;
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
            background-color: #555; /* Highlight for active link */
        }
        .main-content {
            margin-left: 280px; /* Adjusting for sidebar width */
            padding: 20px;
            width: calc(100% - 280px);
        }
        table {
            margin-top: 20px;
            width: 100%;
            background-color: rgba(0, 0, 0, 0.7);
        }
        table th, table td {
            padding: 10px;
            text-align: center;
            border: 1px solid white;
        }
        .btn-custom {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 30px;
            text-decoration: none;
            transition: 0.3s;
        }
        .btn-rezone { background-color: #228B22; }
        .btn-rezone:hover { background-color: #1b4d1b; }
        .btn-remove { background-color: #A52A2A; }
        .btn-remove:hover { background-color: #8B2A2A; }
    </style>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <img src="images/image.png" alt="Logo" class="logo" width="180">
            <h1>Inventory System</h1>
            <a href="{{ route('order') }}" class="nav-link">Place Order</a>
            <a href="{{ route('stacks') }}" class="nav-link {{ Route::is('stacks') || Route::is('stockout') ? 'active' : '' }}">Stocks</a>
            <a href="{{ route('supplier') }}" class="nav-link {{ Route::is('supplier') ? 'active' : '' }}">Supplier</a>
            <a href="{{ route('reports') }}" class="nav-link {{ Route::is('reports') ? 'active' : '' }}">Reports</a>
            <a href="{{ route('login') }}" class="btn-logout"><i class="bi bi-box-arrow-right"></i> Log out</a>
        </div>
        
        <div class="main-content">
            <div>
                <h2>Stock Out Logging</h2>

                @if($products->isEmpty())
                    <p>No products are out of stock.</p>
                @else
                    <table>
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Serial Number</th>
                                <th>Supplier</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->serial_number }}</td>
                                    <td>{{ $product->supplier->supplier_name }}</td>
                                    <td>
                                        <form action="{{ route('restock_product', $product->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-primary">Restock</button>
                                        </form>
                                        <form action="{{ route('remove_product', $product->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i> Remove</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

                <div class="d-flex justify-content-between" style="margin-top: 20px;">
                    <a href="{{ route('stacks') }}" class="btn btn-secondary">← Back</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>