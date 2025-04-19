<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier - Computer Parts Inventory</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <style>
        /* Your existing styles */
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
            background-color: #555;
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

        .modal-content .form-label {
            color: black;
        }

        .modal-header .modal-title {
            color: black;
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
        <!-- Sidebar -->
        <div class="sidebar">
            <img src="images/image.png" alt="Logo" class="logo">
            <h1>Inventory System</h1>
            <a href="{{ route('order') }}" class="nav-link">Place Order</a>
            <a href="{{ route('stacks') }}" class="nav-link {{ Route::is('stacks') ? 'active' : '' }}">Stocks</a>
            <a href="{{ route('supplier') }}" class="nav-link {{ Route::is('supplier') ? 'active' : '' }}">Supplier</a>
            <a href="{{ route('reports') }}" class="nav-link {{ Route::is('reports') ? 'active' : '' }}">Reports</a>
            <a href="{{ route('login') }}" class="logout-btn logout-btn:hover"><i class="bi bi-box-arrow-right"></i> Log out</a>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <h2>Suppliers List</h2>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            <div style="position: relative; height: 400px; overflow-y: auto; border: 1px solid #000; border-radius: 10px; background: rgba(0, 0, 0, 0.7); padding: 10px; margin-top: 20px;">
                <table id="suppliers-table">
                    <thead>
                        <tr>
                            <th>Supplier Name</th>
                            <th>Supplier No</th>
                            <th>Location</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($suppliers as $supplier)
                            <tr>
                                <td>{{ $supplier->supplier_name }}</td>
                                <td>{{ $supplier->supplier_no }}</td>
                                <td>{{ $supplier->location }}</td>
                                <td>
                                    <!-- Edit Button -->
                                    <button type="button" class="btn btn-outline-warning btn-sm" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editSupplierModal" 
                                            data-id="{{ $supplier->id }}"
                                            data-name="{{ $supplier->supplier_name }}" 
                                            data-no="{{ $supplier->supplier_no }}" 
                                            data-location="{{ $supplier->location }}">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </button>
                                    
                                    <!-- Delete Form -->
                                    <form action="{{ route('supplier.destroy', $supplier->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm"> <i class="bi bi-trash"></i> Remove</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="bottom-buttons">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createSupplierModal">
                    Add New Supplier <i class="bi bi-plus-circle"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Modal for Creating New Supplier -->
    <div class="modal fade" id="createSupplierModal" tabindex="-1" aria-labelledby="createSupplierModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createSupplierModalLabel">Add New Supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('supplier.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="supplier_name" class="form-label">Supplier Name</label>
                            <input type="text" class="form-control" id="supplier_name" name="supplier_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="supplier_no" class="form-label">Supplier No</label>
                            <input type="text" class="form-control" id="supplier_no" name="supplier_no" required>
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" class="form-control" id="location" name="location" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add Supplier</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Editing Supplier -->
    <div class="modal fade" id="editSupplierModal" tabindex="-1" aria-labelledby="editSupplierModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSupplierModalLabel">Edit Supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editSupplierForm" action="" method="POST">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" id="supplier_id" name="supplier_id">
                        <div class="mb-3">
                            <label for="edit_supplier_name" class="form-label">Supplier Name</label>
                            <input type="text" class="form-control" id="edit_supplier_name" name="supplier_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_supplier_no" class="form-label">Supplier No</label>
                            <input type="text" class="form-control" id="edit_supplier_no" name="supplier_no" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_location" class="form-label">Location</label>
                            <input type="text" class="form-control" id="edit_location" name="location" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update Supplier</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Script to handle the editing of a supplier
        const editSupplierModal = document.getElementById('editSupplierModal');
        editSupplierModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget; // Button that triggered the modal
            const supplierId = button.getAttribute('data-id');
            const supplierName = button.getAttribute('data-name');
            const supplierNo = button.getAttribute('data-no');
            const location = button.getAttribute('data-location');

            // Update the modal's content
            const modalForm = document.getElementById('editSupplierForm');
            modalForm.action = `/supplier/${supplierId}`; // Assuming the routes are set correctly
            document.getElementById('supplier_id').value = supplierId;
            document.getElementById('edit_supplier_name').value = supplierName;
            document.getElementById('edit_supplier_no').value = supplierNo;
            document.getElementById('edit_location').value = location;
        });
    </script>
</body>
</html>