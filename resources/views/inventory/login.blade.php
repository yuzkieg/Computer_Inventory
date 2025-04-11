<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <style>
        body {
            background: url('images/background_image.png') no-repeat center center fixed;
            background-size: cover;
            color: white;
        }
        .container {
            max-width: 500px;
            padding: 20px;
            border-radius: 10px;
            background-color: rgba(0, 0, 0, 0.7); /* Added semi-transparent background for contrast */
        }
        .form-control, .form-select {
            background-color: #333;
            color: white;
            border: 1px solid #555;
        }
        .form-control:focus, .form-select:focus {
            border-color: #007bff; /* Highlight border on focus */
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); /* Focus shadow */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container text-center">
            <img src="{{ asset('images/image.png') }}" alt="Logo" width="300">
            <h2 class="p-4">Login</h2>

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" class="form-control w-50 mx-auto" name="username" required>  <!-- Adjusted width -->
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control w-50 mx-auto" name="password" required>  <!-- Adjusted width -->
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-outline-success bi bi-person-circle"> Log in</button>
                </div>
                <div class="mb-3 text-center">
                    <p>Don't have an account? <a href="{{ route('register') }}" class="text-light">Sign Up</a></p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>