<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Out</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
       body {
            background: url('images/background_image.png') no-repeat center center fixed;
            background-size: cover;
            color: white;
        }
        .container {
            max-width: 500px;
            background-size: cover;
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
        <div>
            <img src="images/image.png" alt="Logo" width="200">
            <h2>Stock Out</h2>
        </div>
        <form action="stock_in.php" method="POST">
            <div class="mb-3">
                <label class="form-label">Product Name:</label>
                <input type="text" class="form-control" name="product_name" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Quantity:</label>
                <input type="number" class="form-control" name="quantity" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Serial Number:</label>
                <input type="text" class="form-control" name="serial_number" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Price:</label>
                <input type="text" class="form-control" name="price" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Supplier:</label>
                <select class="form-select" name="supplier" required>
                    <option value="">Select Supplier</option>
                    <option value="Supplier 1">Supplier 1</option>
                    <option value="Supplier 2">Supplier 2</option>
                </select>
            </div>
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-success">✓ Save Product</button>
                <a href="{{ route('stacks') }}" class="btn btn-danger">← Back</a>
            </div>
        </form>
    </div>
</body>
</html>