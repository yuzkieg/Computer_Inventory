<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports - Computer Parts Inventory</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body {
            background: url('{{ asset('images/background_image.png') }}') no-repeat center center fixed;
            background-size: cover;
            color: white;
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

        .active {
            background-color: #444; /* Highlight color for active link */
            border-radius: 5px;
        }

        .logout-btn {
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

        .logout-btn:hover {
            background-color: #660313;
        }

        .main-content {
            margin-left: 270px; /* Adjust based on sidebar width */
            padding: 20px;
            flex-grow: 1;
        }

        .container-box {
            max-width: 1100px;
            margin: auto;
            margin-top: 3%;
            padding: 20px;
            text-align: center;
        }

        .logo {
            width: 150px;
            margin-bottom: 20px;
        }

        h2 {
            font-size: 28px;
            font-weight: bold;
            text-align: left;
        }

        table {
            width: 100%;
            text-align: center;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            padding: 10px;
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
            color: white;
        }

        /* Button Colors */
        .btn-print { background-color: #2d6a4f; }
        .btn-print:hover { background-color: #1b4332; }

        .btn-back { background-color: #8b4d4d; }
        .btn-back:hover { background-color: #6a3a3a; }

        .btn-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <img src="{{ asset('images/image.png') }}" alt="Logo" class="logo">
            <h1>Inventory System</h1>
            <a href="{{ route('order') }}" class="nav-link {{ request()->routeIs('order') ? 'active' : '' }}">Place Order</a>
            <a href="{{ route('stacks') }}" class="nav-link {{ request()->routeIs('stacks') ? 'active' : '' }}">Stocks</a>
            <a href="{{ route('supplier') }}" class="nav-link {{ request()->routeIs('supplier') ? 'active' : '' }}">Supplier</a>
            <a href="{{ route('reports') }}" class="nav-link {{ request()->routeIs('reports') ? 'active' : '' }}">Reports</a>
            <a href="{{ route('login') }}" class="logout-btn"><i class="bi bi-box-arrow-right"></i> Log out</a>
        </div>

        <div class="main-content">
            <div class="container-box">
                <h2>Reports</h2>

                <table>
                    <thead>
                        <tr>
                            <th>Reorder</th>
                            <th>Item No.</th>
                            <th>Product Name</th>
                            <th>Supplier</th>
                            <th>Cost Per Item</th>
                            <th>Stock Quantity</th>
                            <th>Inventory Value</th>
                            <th>Item Reorder Quantity</th>
                            <th>Item Discontinued</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="9">No data available</td>
                        </tr>
                    </tbody>
                </table>

                <div class="btn-container">
                    <a href="{{ route('order') }}" class="btn btn-custom btn-back"><i class="bi bi-arrow-left"></i> Back</a>
                    <button class="btn btn-custom btn-print" onclick="window.print()"><i class="bi bi-printer"></i> Print</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>