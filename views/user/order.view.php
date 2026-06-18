<?php require base_path('views/partials/head.php') ?>
<?php require base_path('views/partials/nav.php') ?>

<style>
    :root {
        --gold: #B8973A;
        --gold-lt: #D4AF55;
        --bg: #FDFAF4;
        --white: #FFFFFF;
        --dark: #1E1A12;
        --text: #2C2418;
        --border: rgba(184,151,58,.25);
    }

    .order-page {
        max-width: 1000px;
        margin: 40px auto;
        padding: 0 20px;
        font-family: 'Jost', sans-serif;
    }

    .order-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 3rem;
        text-align: center;
        color: var(--dark);
        margin-bottom: 40px;
    }

    .order-container {
        display: grid;
        grid-template-columns: 1.2fr 0.8fr;
        gap: 30px;
    }

    /* Cart Items Table */
    .cart-section {
        background: var(--white);
        padding: 25px;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        border: 1px solid var(--border);
    }

    .cart-table {
        width: 100%;
        border-collapse: collapse;
    }

    .cart-table th {
        text-align: left;
        padding-bottom: 15px;
        border-bottom: 2px solid var(--bg);
        color: var(--gold);
    }

    .cart-table td {
        padding: 15px 0;
        border-bottom: 1px solid var(--bg);
    }

    .item-qty-control {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .qty-btn {
        background: var(--bg);
        border: 1px solid var(--gold-lt);
        width: 25px;
        height: 25px;
        border-radius: 5px;
        cursor: pointer;
        color: var(--gold);
        font-weight: bold;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .remove-btn {
        color: #ff4d4d;
        background: none;
        border: none;
        cursor: pointer;
        font-size: 0.8rem;
        padding: 0;
        margin-top: 5px;
    }

    /* Form Section */
    .form-section {
        background: var(--white);
        padding: 25px;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        border: 1px solid var(--border);
        height: fit-content;
    }

    .field-order {
        margin-bottom: 20px;
    }

    .field-order label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: var(--text);
    }

    .field-order input, .field-order select, .field-order textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid var(--border);
        border-radius: 8px;
        font-family: 'Jost', sans-serif;
        box-sizing: border-box;
    }

    .total-box {
        margin-top: 20px;
        padding-top: 20px;
        border-top: 2px dashed var(--gold-lt);
        display: flex;
        justify-content: space-between;
        font-size: 1.2rem;
        font-weight: 700;
    }

    .confirm-btn {
        width: 100%;
        background: var(--gold);
        color: white;
        border: none;
        padding: 15px;
        border-radius: 10px;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        margin-top: 20px;
        transition: 0.3s;
    }

    .confirm-btn:hover {
        background: var(--dark);
    }

    @media (max-width: 768px) {
        .order-container { grid-template-columns: 1fr; }
    }
</style>

<div class="order-page">
    <h1 class="order-title">Complete Your Order</h1>

    <div class="order-container">
        <!-- Cart Items -->
        <div class="cart-section">
            <h3 style="margin-bottom: 20px; color: var(--dark);">Your Selection</h3>
            <table class="cart-table" id="cart-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th style="text-align: right;">Price</th>
                    </tr>
                </thead>
                <tbody id="cart-items">
                    <!-- Items will be loaded here by JS -->
                </tbody>
            </table>
            <div id="empty-cart-msg" style="display: none; text-align: center; padding: 30px;">
                <p style="margin-bottom: 15px;">Your cart is empty.</p>
                <a href="/user/products" style="color: var(--gold); font-weight: 600;">Go back to menu</a>
            </div>
        </div>

        <!-- Form -->
        <div class="form-section">
            <form id="order-form">
                <div class="field-order">
                    <label>Delivery Location</label>
                    <select id="location" name="location" required>
                        <option value="hall">In Cafe Hall</option>
                        <option value="room">Hotel Room</option>
                    </select>
                </div>

                <div class="field-order" id="room-field" style="display: none;">
                    <label>Room Number</label>
                    <input type="text" name="room" placeholder="Enter room number">
                </div>

                <div class="field-order" id="table-field">
                    <label>Table Number</label>
                    <input type="text" name="table" placeholder="Enter table number">
                </div>

                <div class="field-order">
                    <label>Notes (Optional)</label>
                    <textarea name="notes" rows="3" placeholder="Any special requests?"></textarea>
                </div>

                <div class="total-box">
                    <span>Total Amount:</span>
                    <span id="order-total">0.00 EGP</span>
                </div>

                <button type="button" onclick="confirmOrder()" class="confirm-btn">
                    Confirm Order
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function getCart() {
        return JSON.parse(localStorage.getItem('cafe_order')) || [];
    }

    function renderCart() {
        const cart = getCart();
        const tbody = document.getElementById('cart-items');
        const cartTable = document.getElementById('cart-table');
        const emptyMsg = document.getElementById('empty-cart-msg');
        const totalEl = document.getElementById('order-total');
        
        if (cart.length === 0) {
            cartTable.style.display = 'none';
            emptyMsg.style.display = 'block';
            totalEl.innerText = '0.00 EGP';
            return;
        }

        cartTable.style.display = 'table';
        emptyMsg.style.display = 'none';
        tbody.innerHTML = '';
        let total = 0;

        cart.forEach((item, index) => {
            const subtotal = item.price * item.quantity;
            total += subtotal;
            
            tbody.innerHTML += `
                <tr>
                    <td>
                        <strong style="color: var(--text);">${item.name}</strong><br>
                        <button class="remove-btn" onclick="removeItem(${index})">Remove</button>
                    </td>
                    <td>
                        <div class="item-qty-control">
                            <button class="qty-btn" type="button" onclick="updateQty(${index}, -1)">-</button>
                            <span style="min-width: 20px; text-align: center;">${item.quantity}</span>
                            <button class="qty-btn" type="button" onclick="updateQty(${index}, 1)">+</button>
                        </div>
                    </td>
                    <td style="text-align: right; font-weight: 600; color: var(--gold);">${subtotal.toFixed(2)} EGP</td>
                </tr>
            `;
        });

        totalEl.innerText = total.toFixed(2) + ' EGP';
    }

    function updateQty(index, change) {
        let cart = getCart();
        cart[index].quantity += change;
        if (cart[index].quantity < 1) cart[index].quantity = 1;
        localStorage.setItem('cafe_order', JSON.stringify(cart));
        renderCart();
    }

    function removeItem(index) {
        if(confirm("Remove this item?")) {
            let cart = getCart();
            cart.splice(index, 1);
            localStorage.setItem('cafe_order', JSON.stringify(cart));
            renderCart();
        }
    }

    // Location toggle
    document.getElementById('location').addEventListener('change', function() {
        const roomField = document.getElementById('room-field');
        const tableField = document.getElementById('table-field');
        
        if (this.value === 'room') {
            roomField.style.display = 'block';
            tableField.style.display = 'none';
        } else {
            roomField.style.display = 'none';
            tableField.style.display = 'block';
        }
    });

    async function confirmOrder() {
        const cart = getCart();
        if (cart.length === 0) {
            alert("Your cart is empty!");
            return;
        }

        const form = document.getElementById('order-form');
        const formData = new FormData(form);
        
        const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);

        const orderData = {
            location: formData.get('location'),
            room: formData.get('location') === 'room' ? formData.get('room') : 'Table ' + formData.get('table'),
            notes: formData.get('notes'),
            items: cart,
            total_amount: total
        };

        try {
            const response = await fetch('/user/order/store', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(orderData)
            });

            const result = await response.text();
            if (result.includes("success")) {
                alert("Order placed successfully! ☕");
                localStorage.removeItem('cafe_order');
                window.location.href = "/user/my_orders";
            } else {
                alert("Error: " + result);
            }
        } catch (error) {
            console.error("Order error:", error);
            alert("Failed to place order. Please check your connection.");
        }
    }

    document.addEventListener('DOMContentLoaded', renderCart);
</script>

<?php require base_path('views/partials/footer.php') ?>
