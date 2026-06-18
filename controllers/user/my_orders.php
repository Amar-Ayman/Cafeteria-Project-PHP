<?php

use Core\Database;

authorize(isset($_SESSION['user']));

$config = require base_path('config.php');
$db = new Database($config['database']);

$userId = $_SESSION['user']['id'];

$orders = $db->query(
    "SELECT *
     FROM orders
     WHERE user_id = ?
     ORDER BY order_date DESC",
    [$userId]
)->get();

foreach ($orders as &$order) {
    $order['items'] = $db->query(
        "SELECT
            p.name,
            oi.quantity,
            oi.price
         FROM order_items oi
         JOIN products p
         ON p.id = oi.product_id
         WHERE oi.order_id = ?",
        [$order['id']]
    )->get();
}

view("user/my_orders.view.php", [
    'orders' => $orders
]);