<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock In</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <style>
        body {
            background: url('{{ asset('images/background_image.png') }}') no-repeat center center fixed;
            background-size: cover;
            color: white;
        }
        .container {
            max-width: 500px;
            padding: 20px;
            border-radius: 10px;
            color: white;
            background-color: rgba(0, 0, 0, 0.7); /* Background for the container for better visibility */
        }
        .form-control, .form-select {
            background-color: #333;
            color: white;
            border: 1px solid #555;
        }
        .btn-success {
            background-color: #228B22;
            border: none;
        }
        .btn-danger {
            background-color: #A52A2A;
            border: none;
        }
    </style>
</head>
<body>
    <div class="container text-center">
        <img src="{{ asset('images/image.png') }}" alt="Computer Parts Inventory System" class="mb-3" width="200">
        <h2>Stock In</h2>
        <!-- Form to create a new product -->
        <form action="{{ route('product.store') }}" method="POST">
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
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-circle"></i> Create Product
                </button>
                <a href="{{ route('stacks') }}" class="btn btn-danger">
                    <i class="bi bi-arrow-left-circle"></i> Back
                </a>
            </div>
        </form>
    </div>
</body>
</html>