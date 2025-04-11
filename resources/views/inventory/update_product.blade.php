<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
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
    <div class="container text-light">
        <div class="text-center">
            <img src="{{ asset('images/image.png') }}" alt="Logo" class="mb-3" width="200">
            <h2>Update Product</h2>
        </div>
        <form action="{{ route('update_product', $product->id) }}" method="POST">
            @csrf
            <div class="mb-3 text-start">
                <label class="form-label">Product Name:</label>
                <input type="text" class="form-control" name="product_name" value="{{ $product->name }}" required>
            </div>
            <div class="mb-3 text-start">
                <label class="form-label">Quantity:</label>
                <input type="number" class="form-control" name="quantity" value="{{ $product->quantity }}" required>
            </div>
            <div class="mb-3 text-start">
                <label class="form-label">Serial Number:</label>
                <input type="text" class="form-control" name="serial_number" value="{{ $product->serial_number }}" required>
            </div>
            <div class="mb-3 text-start">
                <label class="form-label">Price:</label>
                <input type="text" class="form-control" name="price" value="{{ $product->price }}" required>
            </div>
            <div class="mb-3 text-start">
                <label class="form-label">Supplier:</label>
                <select class="form-select" name="supplier" required>
                    <option value="">Select Supplier</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->supplier_name }}" {{ $supplier->supplier_name == $product->supplier->supplier_name ? 'selected' : '' }}>
                            {{ $supplier->supplier_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-success bi bi-check-circle"> Save Product</button>
                <a href="{{ route('stacks') }}" class="btn btn-danger bi bi-arrow-left-circle"> Back</a>
            </div>
        </form>
    </div>
</body>
</html>