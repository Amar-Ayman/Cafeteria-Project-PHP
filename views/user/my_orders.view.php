<?php require base_path('views/partials/head.php') ?>
<?php require base_path('views/partials/nav.php') ?>

<div class="container">
<h1>My Orders</h1>
<?php if(!empty($orders)): ?>
<?php foreach($orders as $order): ?>
<div class="order-card">
    <div class="order-header">
        <div class="order-id">
            Order #<?= $order['id'] ?>
        </div>
        <div class="status">
            <?= $order['status'] ?>
        </div>
    </div>
    <div class="date">
        <?= $order['order_date'] ?>
    </div>
    <div class="items">
    <?php foreach($order['items'] as $item): ?>
        <div class="item">
            <span>
                <?= $item['name'] ?>
            </span>
            <span>
                x<?= $item['quantity'] ?>
            </span>
        </div>
    <?php endforeach; ?>
    </div>
    <div class="total">
        Total:
        <?= $order['total_amount'] ?>
        EGP
    </div>
</div>
<?php endforeach; ?>
<?php else: ?>
<div class="empty">
    No Orders Yet 
</div>
<?php endif; ?>
</div>
<link rel="stylesheet" href="/css/myOrder.css">