<?php require base_path("views/partials/head.php") ?>
<?php require base_path("views/partials/nav.php") ?>

<style>
    :root {
        --gold: #B8973A;
        --gold-light: #D4AF55;
        --gold-pale: #EDD98A;
        --gold-faint: #F7F0DC;
        --beige: #F5EFE0;
        --beige-dark: #E8DEC8;
        --cream: #FDFAF4;
        --white: #FFFFFF;
        --dark: #1E1A12;
        --text-dark: #2C2418;
        --text-mid: #6B5B3E;
        --text-light: #9E8C6E;
        --shadow: 0 4px 20px rgba(0,0,0,0.08);
    }

    body {
        background-color: var(--cream);
        font-family: 'Jost', sans-serif;
        color: var(--text-dark);
    }

    .admin-container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .orders-card {
        background: var(--white);
        border-radius: 12px;
        box-shadow: var(--shadow);
        padding: 30px;
        margin-bottom: 40px;
        border: 1px solid var(--gold-pale);
    }

    .section-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 2.5rem;
        color: var(--text-dark);
        margin-bottom: 25px;
        border-bottom: 2px solid var(--gold-faint);
        padding-bottom: 10px;
    }

    .orders-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    .orders-table th {
        background-color: var(--beige);
        color: var(--text-dark);
        font-weight: 600;
        text-align: center;
        padding: 15px;
        border-bottom: 2px solid var(--gold-light);
    }

    .orders-table td {
        padding: 15px;
        border-bottom: 1px solid var(--gold-faint);
        text-align: center;
        color: var(--text-mid);
    }

    .orders-table tr:hover {
        background-color: var(--cream);
    }

    .orders-table tr.active-row {
        background-color: var(--gold-faint);
    }

    .status-select {
        padding: 8px 12px;
        border-radius: 6px;
        border: 1px solid var(--gold-light);
        background-color: var(--white);
        color: var(--text-dark);
        font-family: 'Jost', sans-serif;
        cursor: pointer;
    }

    .btn-view {
        color: var(--gold);
        text-decoration: none;
        font-weight: 600;
        margin-right: 15px;
        transition: 0.3s;
    }

    .btn-view:hover {
        color: var(--gold-light);
    }

    .btn-delete {
        background: none;
        border: none;
        color: #d9534f;
        cursor: pointer;
        font-weight: 600;
        font-family: 'Jost', sans-serif;
    }

    .btn-delete:hover {
        text-decoration: underline;
    }

    .details-card {
        background: var(--white);
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(184, 151, 58, 0.15);
        padding: 35px;
        border-top: 5px solid var(--gold);
        animation: fadeIn 0.5s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .details-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .details-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        margin-bottom: 40px;
    }

    .info-box {
        background-color: var(--beige);
        padding: 20px;
        border-radius: 8px;
    }

    .info-box p {
        margin-bottom: 10px;
        color: var(--text-dark);
    }

    .info-box strong {
        color: var(--gold);
        margin-right: 5px;
    }

    .items-table {
        width: 100%;
        border-collapse: collapse;
    }

    .items-table th {
        text-align: left;
        padding: 12px;
        border-bottom: 2px solid var(--gold-pale);
        color: var(--text-mid);
    }

    .items-table td {
        padding: 12px;
        border-bottom: 1px solid var(--gold-faint);
    }

    .total-row {
        font-weight: 700;
        font-size: 1.2rem;
        color: var(--gold);
        background-color: var(--gold-faint);
    }

    .close-link {
        color: var(--text-light);
        text-decoration: none;
        font-size: 0.9rem;
    }

    .close-link:hover {
        color: var(--text-dark);
    }
</style>

<div class="page-header">
    <h1 class="page-title" style="text-align: center; padding: 40px 0; font-family: 'Cormorant Garamond', serif; font-size: 3.5rem;">Orders Management</h1>
    <div class="header-divider" style="width: 100px; height: 3px; background: var(--gold); margin: -20px auto 40px;"></div>
</div>

<div class="admin-container">
    
    <div class="orders-card">
        <h2 class="section-title">All Orders</h2>
        <?php if (empty($orders)) : ?>
            <p style="text-align: center; padding: 20px; color: var(--text-light);">No orders found in the database.</p>
        <?php else : ?>
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                        <th>Room</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order) : ?>
                        <tr class="<?= (isset($selectedOrder) && $selectedOrder['id'] == $order['id']) ? 'active-row' : '' ?>">
                            <td>#<?= $order["id"] ?></td>
                            <td><?= htmlspecialchars($order["user_name"]) ?></td>
                            <td style="font-weight: 600; color: var(--gold);"><?= htmlspecialchars($order["total_amount"]) ?> EGP</td>
                            <td>
                                <form action="/admin/orders" method="POST">
                                    <input type="hidden" name="_method" value="PATCH">
                                    <input type="hidden" name="order_id" value="<?= $order["id"] ?>">
                                    <select name="status" onchange="this.form.submit()" class="status-select">
                                        <option value="processing" <?= $order["status"] === "processing" ? "selected" : "" ?>>Processing</option>
                                        <option value="out for delivery" <?= $order["status"] === "out for delivery" ? "selected" : "" ?>>Out for Delivery</option>
                                        <option value="done" <?= $order["status"] === "done" ? "selected" : "" ?>>Done</option>
                                    </select>
                                </form>
                            </td>
                            <td><?= htmlspecialchars($order["room"]) ?></td>
                            <td><?= date('M d, Y H:i', strtotime($order["order_date"])) ?></td>
                            <td>
                                <a href="/admin/orders?id=<?= $order["id"] ?>#details-section" class="btn-view">View Details</a>
                                <form action="/admin/orders" method="POST" style="display: inline;" onsubmit="return confirm('Delete this order permanently?');">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="order_id" value="<?= $order["id"] ?>">
                                    <button type="submit" class="btn-delete">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <?php if (isset($selectedOrder) && $selectedOrder !== null) : ?>
        <div id="details-section" class="details-card">
            <div class="details-header">
                <h2 class="section-title" style="margin-bottom: 0;">Order #<?= $selectedOrder["id"] ?> Details</h2>
                <a href="/admin/orders" class="close-link">✖ Close Details</a>
            </div>
            
            <div class="details-grid">
                <div class="info-box">
                    <p><strong>Customer:</strong> <?= htmlspecialchars($selectedOrder["user_name"]) ?></p>
                    <p><strong>Room Number:</strong> <?= htmlspecialchars($selectedOrder["user_room_no"]) ?></p>
                    <p><strong>Extension:</strong> <?= htmlspecialchars($selectedOrder["user_ext"]) ?></p>
                    <p><strong>Ordered At:</strong> <?= date('F d, Y - h:i A', strtotime($selectedOrder["order_date"])) ?></p>
                </div>
                <div class="info-box">
                    <p><strong>Delivery Room:</strong> <?= htmlspecialchars($selectedOrder["room"]) ?></p>
                    <p><strong>Total Bill:</strong> <span style="font-weight: 700; color: var(--gold); font-size: 1.1rem;"><?= htmlspecialchars($selectedOrder["total_amount"]) ?> EGP</span></p>
                    <p><strong>Current Status:</strong> <span style="text-transform: uppercase; font-weight: 600; font-size: 0.8rem; letter-spacing: 1px; color: var(--gold);"><?= htmlspecialchars($selectedOrder["status"]) ?></span></p>
                    <p><strong>Notes:</strong> <em><?= htmlspecialchars($selectedOrder["notes"]) ?: "No specific notes." ?></em></p>
                </div>
            </div>

            <h3 style="font-family: 'Cormorant Garamond', serif; font-size: 1.8rem; margin-bottom: 15px; color: var(--text-dark);">Order Items</h3>
            <table class="items-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th style="text-align: center;">Qty</th>
                        <th style="text-align: right;">Unit Price</th>
                        <th style="text-align: right;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($orderItems)) : ?>
                        <?php foreach ($orderItems as $item) : ?>
                            <tr>
                                <td><?= htmlspecialchars($item["product_name"]) ?></td>
                                <td style="text-align: center;"><?= htmlspecialchars($item["quantity"]) ?></td>
                                <td style="text-align: right;"><?= htmlspecialchars($item["price"]) ?> EGP</td>
                                <td style="text-align: right; font-weight: 600;"><?= number_format($item["price"] * $item["quantity"], 2) ?> EGP</td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 20px;">No items found for this order.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
                <tfoot>
                    <tr class="total-row">
                        <td colspan="3" style="text-align: right; padding: 15px;">Grand Total:</td>
                        <td style="text-align: right; padding: 15px;"><?= htmlspecialchars($selectedOrder["total_amount"]) ?> EGP</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        
        <script>
            document.getElementById('details-section').scrollIntoView({ behavior: 'smooth' });
        </script>
    <?php endif; ?>

</div>

<?php require base_path("views/partials/footer.php") ?>
