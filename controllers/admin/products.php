<?php

use Core\Database;
use Core\Auth;

// التحقق من أن المستخدم أدمن
authorize(Auth::check() && $_SESSION['user']['role'] === 'admin');

$config = require base_path('config.php');
$db = new Database($config['database']);

// معالجة عملية الحذف
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $db->query("DELETE FROM products WHERE id = :id", [
        'id' => $_GET['id']
    ]);
    redirect('/admin/products');
}

// جلب جميع المنتجات
$products = $db->query("SELECT * FROM products")->get();

view('admin/products.view.php', [
    'header' => 'Products Management',
    'products' => $products
]);
