<?php

use Core\Database;
use Core\Auth;

// 1. الحماية: التأكد أن الأدمن فقط هو من يشاهد ويدير المستخدمين
authorize(Auth::check() && $_SESSION['user']['role'] === 'admin');

$config = require base_path('config.php');
$db = new Database($config['database']);

// 2. منطق الحذف (Delete Logic)
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $db->query("DELETE FROM users WHERE id = :id", [
        'id' => $_GET['id']
    ]);
    redirect('/admin/users');
}

// 3. جلب جميع المستخدمين لعرضهم
$users = $db->query("SELECT * FROM users")->get();

// 4. عرض الصفحة باستخدام دالة view()
view('admin/users.view.php', [
    'header' => 'Users Management',
    'users'  => $users
]);
