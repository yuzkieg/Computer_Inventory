<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Order</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
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

        .nav-link {
            color: white;
            font-size: 18px;
            margin: 10px 0;
            text-decoration: none;
            transition: 0.3s;
        }

        .nav-link:hover, .active {
            background-color: #444;
            border-radius: 5px;
            padding: 10px;
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
            text-decoration: none;
            transition: 0.3s;
        }

        .logout-btn:hover {
            background-color: #660313;
        }

        .main-content {
            margin-left: 270px;
            padding: 20px;
            flex-grow: 1;
        }

        .logo {
            width: 180px;
            margin-bottom: 20px;
        }

        .modal-body {
            text-align: left;
        }
        .modal-body {
            text-align: left;
            color: black; /* Set text color to black */
        }

        .modal-title {
            color: black; /* Set title color to black */
        }

        .modal-header, .modal-footer {
            background-color: white; /* Optional: Set background to white to contrast with black text */
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
            <h2>Place Order</h2>

            <!-- Product List -->
            <div class="mb-3">
                <h5>Available Products</h5>
                <ul class="list-group" id="productList">
                    @foreach ($products as $product)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $product->name }} - ₱{{ $product->price }}
                            <button class="btn btn-success btn-sm add-to-order" data-name="{{ $product->name }}" data-price="{{ $product->price }}">Add to Order</button>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Order Summary -->
            <h5>Order Summary</h5>
            <div class="border rounded p-2 mb-3">
                <table class="table table-dark table-bordered" id="orderSummary">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Qty</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody id="orderSummaryBody"></tbody>
                </table>
            </div>
            <div id="currentOrderTotalDisplay" class="fw-bold">Total: ₱0.00</div>

            <button type="button" class="btn btn-primary" id="placeOrderBtn">Place Order</button>
        </div>
    </div>

    <!-- Receipt Modal -->
    <div class="modal fade" id="receiptModal" tabindex="-1" aria-labelledby="receiptModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="receiptModalLabel">Order Receipt</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6>Your Order:</h6>
                    <ul id="receiptItems"></ul>
                    <p>Total: ₱<span id="totalAmount"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let orders = [];
        let totalPriceCurrentOrder = 0;

        document.querySelectorAll('.add-to-order').forEach(button => {
            button.addEventListener('click', function() {
                const name = this.getAttribute('data-name');
                const price = parseFloat(this.getAttribute('data-price'));

                const existingOrder = orders.find(order => order.name === name);
                if (existingOrder) {
                    existingOrder.qty += 1; // Increase quantity
                } else {
                    orders.push({ name, price, qty: 1 }); // Add new order
                }

                updateOrderSummary();
            });
        });

        function updateOrderSummary() {
            const summaryBody = document.getElementById('orderSummaryBody');
            summaryBody.innerHTML = '';
            totalPriceCurrentOrder = 0;

            orders.forEach(order => {
                const orderRow = document.createElement('tr');
                const priceTotal = order.price * order.qty;

                orderRow.innerHTML = `
                    <td>${order.name}</td>
                    <td><input type="number" class="form-control" value="${order.qty}" min="1" data-price="${order.price}" data-name="${order.name}"></td>
                    <td>₱${priceTotal.toFixed(2)}</td>
                `;

                summaryBody.appendChild(orderRow);
                totalPriceCurrentOrder += priceTotal;
            });

            summaryBody.querySelectorAll('input[type="number"]').forEach(input => {
                input.addEventListener('change', function() {
                    const newQty = parseInt(this.value);
                    const orderToUpdate = orders.find(order => order.name === this.getAttribute('data-name'));
                    if (orderToUpdate) {
                        orderToUpdate.qty = newQty < 1 ? 1 : newQty; // Minimum quantity
                    }
                    updateOrderSummary();
                });
            });

            document.getElementById('currentOrderTotalDisplay').textContent = `Total: ₱${totalPriceCurrentOrder.toFixed(2)}`;
        }

        document.getElementById('placeOrderBtn').addEventListener('click', function() {
            const orderData = orders.map(order => ({
                name: order.name,
                price: order.price,
                qty: order.qty
            }));

            const totalAmount = totalPriceCurrentOrder;

            console.log('Order data:', orderData); // Log order data for debugging

            fetch('/place-order', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    orders: orderData,
                    totalAmount: totalAmount
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                console.log(data);
                
                // Show receipt modal
                showReceipt(orderData, totalAmount);
                
                // Clear the orders and reset the UI
                orders = [];
                updateOrderSummary(); // Clear summary
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });

        // Function to show the receipt modal
        function showReceipt(orderData, totalAmount) {
            const receiptItems = document.getElementById('receiptItems');
            receiptItems.innerHTML = ''; // Clear any existing items

            orderData.forEach(order => {
                const item = document.createElement('li');
                item.textContent = `${order.name} - Qty: ${order.qty} - Price: ₱${(order.price * order.qty).toFixed(2)}`;
                receiptItems.appendChild(item);
            });

            document.getElementById('totalAmount').textContent = totalAmount.toFixed(2);

            // Display the modal
            const receiptModal = new bootstrap.Modal(document.getElementById('receiptModal'));
            receiptModal.show();
        }
    </script>
</body>
</html>