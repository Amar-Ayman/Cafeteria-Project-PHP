<?php

use Core\Database;
use Core\Auth;

// التحقق من أن المستخدم أدمن
authorize(Auth::check() && $_SESSION['user']['role'] === 'admin');

$config = require base_path('config.php');
$db = new Database($config['database']);

$id = $_GET['id'] ?? null;

if (!$id) {
    abort();
}

// جلب بيانات المنتج الحالي
$product = $db->query("SELECT * FROM products WHERE id = :id", [
    'id' => $id
])->findOrFail();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['product-name'];
    $price = $_POST['price'];
    $category_id = $_POST['category']; 
    $status = $_POST['status'] ?? 'available';
    $image_name = $product['image']; // الصورة القديمة كافتراضي

    if (!empty($_FILES['product-picture']['name'])) {
        $image_name = $_FILES['product-picture']['name'];
        move_uploaded_file($_FILES['product-picture']['tmp_name'], base_path("public/images/" . $image_name));
    }

    $db->query("UPDATE products SET name = :name, price = :price, category_id = :category_id, image = :image, status = :status WHERE id = :id", [
        'id' => $id,
        'name' => $name,
        'price' => $price,
        'category_id' => $category_id,
        'image' => $image_name,
        'status' => $status
    ]);

    redirect('/admin/products');
}

$categories = $db->query("SELECT * FROM categories")->get();

view('admin/edit_product.view.php', [
    'header' => 'Edit Product',
    'product' => $product,
    'categories' => $categories
]);
