<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome -->
    <style>
        body {
            background: url('images/background_image.png') no-repeat center center fixed;
            background-size: cover;
            color: white;
        }
        .flex-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; 
        }
        .register-container {
            max-width: 500px;
            padding: 20px;
            margin-left: 10%;
            border-radius: 10px;
            background-color: rgba(0, 0, 0, 0.7);
            flex: 1;
        }
        .logo-container {
            flex: 1; 
            text-align: center;
        }
        .form-control, .form-select {
            background-color: #333; 
            color: white; 
            border: 1px solid #555;
        }
        .form-control:focus, .form-select:focus {
            border-color: #007bff; 
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); 
        }
    </style>
</head>
<body>
    <div class="flex-container">
        <div class="register-container">
            <h2>Create Account</h2>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="mb-3 text-start">
                    <label class="form-label">First Name</label>
                    <input type="text" class="form-control" name="first_name" required>
                </div>
                <div class="mb-3 text-start">
                    <label class="form-label">Middle Name</label>
                    <input type="text" class="form-control" name="middle_name">
                </div>
                <div class="mb-3 text-start">
                    <label class="form-label">Last Name</label>
                    <input type="text" class="form-control" name="last_name" required>
                </div>
                <div class="mb-3 text-start">
                    <label class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" required>
                </div>
                <div class="mb-3 text-start">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" required>
                </div>
                <div class="mb-3 text-start">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" name="password_confirmation" required>
                </div>
                <a href="{{ route('login') }}" class="btn btn-sm btn-secondary" style="margin-right: 24%;"><i class="fas fa-arrow-left"></i> Back</a>
                <button type="submit" class="btn btn-success"><i class="fas fa-user-plus"></i> Sign Up</button>
       
            </form>
        </div>
        <div class="logo-container">
            <img src="{{ asset('images/image.png') }}" alt="Logo" width="500"> 
        </div>
    </div>
</body>
</html>