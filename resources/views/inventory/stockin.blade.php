<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Stock In</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css"/>
    <style>
        body {
            background: url('{{ asset('images/background_image.png') }}') no-repeat center center fixed;
            background-size: cover;
            color: white;
        }
        .container {
            max-width: 1000px;
            padding: 20px;
            border-radius: 10px;
            color: white;
            background-color: rgba(0, 0, 0, 0.7); /* Background for better visibility */
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 0.75rem;
            text-align: left;
            border: 1px solid #555;
        }
        th {
            background-color: #444;
        }
        /* Optional: Style for scrollable table if many records */
        .table-responsive {
            max-height: 500px;
            overflow-y: auto;
        }
        /* Optional: Add spacing for header */
        .header-row {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <!-- Header with logo at upper left corner -->
    <div class="container-fluid px-3 py-2" style="background-color: rgba(0,0,0,0.7); position: fixed; top: 0; width: 100%; z-index: 1050;">
        <div class="row align-items-center">
            <div class="col-auto">
                <img src="{{ asset('images/image.png') }}" alt="Computer Parts Inventory System" width="200" />
            </div>
        </div>
    </div>

    <!-- Main content, with top padding to avoid overlap with fixed header -->
    <div class="container" style="padding-top: 130px;">
        <div class="text-center">
            <h2 class="text-white">Stock In Records</h2>
        </div>
        <!-- Table displaying stock-in logs -->
        <div class="table-responsive mt-4">
            <table class="table table-dark table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Serial Number</th>
                        <th>Supplier</th>
                        <th>Product Lifespan</th>
                        <th>Supplier Warranty</th>
                        <th>Date Received</th>
                    </tr>
                </thead>
                {{-- <tbody>
                    @forelse($stockIns as $stock)
                        <tr>
                            <td>{{ $stock->product_name }}</td>
                            <td>{{ $stock->quantity }}</td>
                            <td>{{ $stock->price }}</td>
                            <td>{{ $stock->serial_number }}</td>
                            <td>{{ $stock->supplier }}</td>
                            <td>{{ $stock->product_lifespan }}</td>
                            <td>{{ $stock->supplier_warranty }}</td>
                            <td>{{ $stock->date_received }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No stock-in records available.</td>
                        </tr>
                    @endforelse
                </tbody> --}}
            </table>
        </div>
        <a href="{{ route('stacks') }}" class="btn btn-secondary mt-3">
            <i class="bi bi-arrow-left-circle"></i> Back
        </a>
    </div>
</body>
</html>