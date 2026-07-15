<?php require base_path('views/partials/head.php') ?>
<?php require base_path('views/partials/nav.php') ?>

<style>
    /* My Orders Page Specific Styles */
    .my-orders-container {
        max-width: 900px;
        margin: 50px auto;
        padding: 0 20px 80px;
    }

    .my-orders-header {
        text-align: center;
        margin-bottom: 50px;
    }

    .my-orders-header h1 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 3.5rem;
        color: var(--text-dark);
        margin-bottom: 15px;
        font-weight: 700;
    }

    .my-orders-header h1::after {
        content: '';
        display: block;
        width: 100px;
        height: 3px;
        background: var(--gold);
        margin: 20px auto 0;
        border-radius: 2px;
    }

    .my-orders-header p {
        color: var(--text-light);
        font-size: 1rem;
        margin-top: 15px;
    }

    /* Order Cards */
    .order-card {
        background: var(--white);
        border: 2px solid var(--beige-dark);
        border-radius: 12px;
        padding: 32px;
        margin-bottom: 28px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .order-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(180deg, var(--gold), var(--gold-light));
    }

    .order-card {
        position: relative;
    }

    .order-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(184, 151, 58, 0.15);
        border-color: var(--gold-light);
    }

    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
        padding-bottom: 16px;
        border-bottom: 1px solid var(--beige-dark);
    }

    .order-id {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--text-dark);
    }

    .status {
        padding: 8px 18px;
        border-radius: 25px;
        font-size: 0.8rem;
        font-weight: 700;
        letter-spacing: 0.8px;
        text-transform: uppercase;
        background: linear-gradient(135deg, var(--gold-faint), var(--gold-pale));
        color: var(--gold);
        border: 2px solid var(--gold-light);
        box-shadow: 0 2px 8px rgba(184, 151, 58, 0.2);
    }

    .order-date {
        color: var(--text-light);
        font-size: 0.95rem;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .order-date::before {
        content: '📅';
        font-size: 1.1rem;
    }

    .items-section {
        margin-bottom: 20px;
    }

    .items-label {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--text-mid);
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 12px;
        display: block;
    }

    .items {
        border-top: 2px solid var(--beige-dark);
        border-bottom: 2px solid var(--beige-dark);
        padding: 16px 0;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        transition: all 0.2s ease;
    }

    .item:hover {
        padding-left: 8px;
        color: var(--gold);
    }

    .item-name {
        color: var(--text-dark);
        font-size: 1rem;
        font-weight: 500;
    }

    .item-quantity {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .item-qty-badge {
        background: var(--gold-faint);
        color: var(--gold);
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        border: 1px solid var(--gold-pale);
    }

    .order-total {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 12px;
        padding-top: 16px;
        border-top: 1px solid var(--beige-dark);
    }

    .total-label {
        font-size: 0.95rem;
        color: var(--text-mid);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .total-amount {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--gold);
        background: linear-gradient(135deg, var(--gold), var(--gold-light));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .currency {
        font-size: 0.9rem;
        color: var(--text-mid);
        font-weight: 600;
    }

    /* Empty State */
    .empty-state {
        background: linear-gradient(135deg, var(--white), var(--beige));
        border: 2px dashed var(--gold-light);
        border-radius: 12px;
        padding: 80px 40px;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
    }

    .empty-state-icon {
        font-size: 4rem;
        margin-bottom: 20px;
        display: block;
    }

    .empty-state-text {
        color: var(--text-light);
        font-size: 1.2rem;
        margin-bottom: 20px;
        font-weight: 500;
    }

    .empty-state-subtext {
        color: var(--text-light);
        font-size: 0.95rem;
        margin-bottom: 30px;
    }

    .cta-button {
        display: inline-block;
        background: linear-gradient(135deg, var(--gold), var(--gold-light));
        color: var(--white);
        padding: 12px 32px;
        border-radius: 25px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(184, 151, 58, 0.3);
        border: none;
        cursor: pointer;
    }

    .cta-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(184, 151, 58, 0.4);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .my-orders-header h1 {
            font-size: 2.5rem;
        }

        .order-card {
            padding: 24px;
        }

        .order-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }

        .order-id {
            font-size: 1.5rem;
        }

        .status {
            align-self: flex-start;
        }

        .item {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }

        .order-total {
            flex-direction: column;
            align-items: flex-start;
        }

        .empty-state {
            padding: 60px 30px;
        }

        .empty-state-icon {
            font-size: 3rem;
        }
    }
</style>

<div class="my-orders-container">
    <div class="my-orders-header">
        <h1>My Orders</h1>
        <p>Track and manage your orders</p>
    </div>

    <?php if(!empty($orders)): ?>
        <?php foreach($orders as $order): ?>
            <div class="order-card">
                <div class="order-header">
                    <div class="order-id">Order #<?= htmlspecialchars($order['id']) ?></div>
                    <div class="status"><?= htmlspecialchars($order['status']) ?></div>
                </div>
                
                <div class="order-date">
                    <?= htmlspecialchars($order['order_date']) ?>
                </div>

                <label class="items-label">Items</label>
                <div class="items">
                    <?php foreach($order['items'] as $item): ?>
                        <div class="item">
                            <span class="item-name"><?= htmlspecialchars($item['name']) ?></span>
                            <span class="item-quantity">
                                <span class="item-qty-badge">x<?= htmlspecialchars($item['quantity']) ?></span>
                            </span>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="order-total">
                    <span class="total-label">Total:</span>
                    <span class="total-amount"><?= htmlspecialchars($order['total_amount']) ?></span>
                    <span class="currency">EGP</span>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="empty-state">
            <span class="empty-state-icon">🛒</span>
            <div class="empty-state-text">No Orders Yet</div>
            <div class="empty-state-subtext">Start exploring our menu and place your first order</div>
            <a href="/user/products" class="cta-button">Browse Menu</a>
        </div>
    <?php endif; ?>
</div>

<?php require base_path('views/partials/footer.php') ?>
