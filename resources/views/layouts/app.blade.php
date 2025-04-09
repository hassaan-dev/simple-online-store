<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Online Shop')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        .cart-badge {
            position: relative;
            top: -10px;
            right: 5px;
            font-size: 0.7em;
        }
        .product-card:hover {
            transform: translateY(-5px);
            transition: transform 0.3s ease;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
    </style>
    @yield('styles')
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">Online Shop</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products.index') }}">Products</a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('orders.my') }}">My Orders</a>
                        </li>
                        @if(Auth::user()->isAdmin())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">Admin Dashboard</a>
                            </li>
                        @endif
                    @endauth
                </ul>
                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="#" id="cart-button">
                                <i class="bi bi-cart"></i>
                                <span id="cart-count" class="badge bg-danger cart-badge">0</span>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
</header>

<main class="container py-4">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @yield('content')
</main>

<!-- Shopping Cart Modal -->
<div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cartModalLabel">Shopping Cart</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="cart-items" class="mb-3">
                    <!-- Cart items will be inserted here via JavaScript -->
                </div>
                <div id="cart-empty-message" class="text-center py-4">
                    Your cart is empty.
                </div>
                <div id="cart-total" class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                    <h5>Total:</h5>
                    <h5 id="cart-total-amount">$0.00</h5>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Continue Shopping</button>
                <button type="button" class="btn btn-success" id="checkout-button" disabled>Proceed to Checkout</button>
            </div>
        </div>
    </div>
</div>

<!-- Checkout Modal -->
<div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="checkoutModalLabel">Complete Your Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="checkout-form">
                    <div class="mb-3">
                        <label for="shipping-address" class="form-label">Shipping Address</label>
                        <textarea class="form-control" id="shipping-address" rows="3" required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="place-order-button">Place Order</button>
            </div>
        </div>
    </div>
</div>

<!-- Order Success Modal -->
<div class="modal fade" id="orderSuccessModal" tabindex="-1" aria-labelledby="orderSuccessModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="orderSuccessModalLabel">Order Placed Successfully!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Your order has been placed successfully. Your order ID is: <strong id="success-order-id"></strong></p>
                <p>You can check the status of your order in the "My Orders" section.</p>
            </div>
            <div class="modal-footer">
                <a href="{{ route('home') }}" class="btn btn-primary">Continue Shopping</a>
                <a href="{{ route('orders.my') }}" class="btn btn-info text-white">View My Orders</a>
            </div>
        </div>
    </div>
</div>

<footer class="bg-dark text-white py-4 mt-5">
    <div class="container text-center">
        <p>&copy; {{ date('Y') }} Online Shop. All rights reserved.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    // initialize cart from localStorage
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    updateCartCount();

    // cart button event
    document.getElementById('cart-button').addEventListener('click', function (e) {
        e.preventDefault();
        showCartModal();
    });

    // checkout button event
    document.getElementById('checkout-button').addEventListener('click', function () {

        // hide cart modal and show checkout modal
        const cartModal = bootstrap.Modal.getInstance(document.getElementById('cartModal'));
        cartModal.hide();

        const checkoutModal = new bootstrap.Modal(document.getElementById('checkoutModal'));
        checkoutModal.show();
    });

    // place order button event
    document.getElementById('place-order-button').addEventListener('click', function () {
        const shippingAddress = document.getElementById('shipping-address').value;

        if( !shippingAddress.trim() ) {
            alert('Please enter a shipping address');
            return;
        }

        // place order function
        placeOrder(shippingAddress);
    });

    // function to update cart count badge
    function updateCartCount() {
        const cartCount = document.getElementById('cart-count');
        cartCount.textContent = cart.reduce((total,item) => total + item.quantity, 0)
    }

    // function to show cart modal
    function showCartModal() {
        const cartItemsContainer = document.getElementById('cart-items');
        const cartEmptyMessage = document.getElementById('cart-empty-message');
        const cartTotalAmount = document.getElementById('cart-total-amount');
        const checkoutButton = document.getElementById('checkout-button');

        // clear previous items
        cartItemsContainer.innerHTML = '';

        if( cart.length === 0 ) {
            cartEmptyMessage.style.display = 'block';
            checkoutButton.disabled = true;
            cartTotalAmount.textContent = '$0.00';
        }
        else
        {
            cartEmptyMessage.style.display = 'none';
            checkoutButton.disabled = false;

            let total = 0;

            // create cart item elements
            cart.forEach((item, index) => {
                const itemTotal = item.price * item.quantity;
                total += itemTotal;

                const itemElement = document.createElement('div');
                itemElement.className = 'cart-item d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom';
                itemElement.innerHTML = `
                <div>
                    <h6 class="mb-0">${item.name}</h6>
                    <small>$${item.price.toFixed(2)} x ${item.quantity}</small>
                </div>
                <div class="d-flex align-items-center">
                    <span>$${itemTotal.toFixed(2)}</span>
                    <button class="btn btn-sm btn-outline-danger remove-item" data-index="${index}"><i class="bi bi-trash"></i></button>
                </div>
                `;

                cartItemsContainer.appendChild(itemElement);
            });

            // update total
            cartTotalAmount.textContent = '$' + total.toFixed(2);

            // event listener to remove button
            document.querySelectorAll('.remove-item').forEach(button => {
                button.addEventListener('click', function () {
                    const index = parseInt(this.getAttribute('data-index'));
                    removeCartItem(index);
                    showCartModal();
                })
            });
        }

        // show modal
        const cartModal = new bootstrap.Modal(document.getElementById('cartModal'));
        cartModal.show();
    }

    // function to remove item from cart
    function removeCartItem(index) {
        cart.splice(index, 1);

        localStorage.setItem('cart', JSON.stringify(cart));
        updateCartCount();
    }

    // function to place order
    function placeOrder(shippingAddress) {

        // prepare order data
        const orderData = {
            items: cart.map(item => ({
                product_id: item.id,
                quantity: item.quantity,
            })),
            shipping_address: shippingAddress
        }

        // send order to server
        fetch(window.location.origin + '/public/api/checkout', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify(orderData)
        })
        .then(response => {

            if( !response.ok ) {
                return response.json().then(data => {
                    throw new Error(data.error || 'An error occurred while placing your order');
                })
            }

            return response.json();
        })
        .then(data => {

            // close checkout modal
            const checkoutModal = bootstrap.Modal.getInstance(document.getElementById('checkoutModal'));
            checkoutModal.hide();

            // show success modal
            document.getElementById('success-order-id').textContent = data.order_id;
            const successModal = new bootstrap.Modal(document.getElementById('orderSuccessModal'));
            successModal.show();

            // clear cart
            cart = [];
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartCount();

        }).catch(error => {
                alert(error.message);
            });

    }

    // add to cart buttons
    window.addToCart = function (productId, productName, productPrice) {
        const existingItem = cart.find(item => item.id === productId);

        if(existingItem) {
            existingItem.quantity += 1;
        } else {
            cart.push({
                id: productId,
                name: productName,
                price: productPrice,
                quantity: 1
            });
        }

        localStorage.setItem('cart', JSON.stringify(cart));
        updateCartCount();
    }

});
</script>
@yield('scripts')
</body>
</html>
