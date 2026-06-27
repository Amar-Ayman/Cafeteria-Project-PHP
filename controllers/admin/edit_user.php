<?php

use Core\Database;
use Core\Auth;

// 1. الحماية: التأكد أن الأدمن فقط هو من يعدل بيانات المستخدمين
authorize(Auth::check() && $_SESSION['user']['role'] === 'admin');

$config = require base_path('config.php');
$db = new Database($config['database']);

$id = $_GET['id'] ?? null;

if (!$id) {
    abort();
}

// 2. جلب بيانات المستخدم الحالي
$user = $db->query("SELECT * FROM users WHERE id = :id", [
    'id' => $id
])->findOrFail();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = $_POST['name'];
    $email   = $_POST['email'];
    $room_no = $_POST['Room_No']; 
    $ext     = $_POST['Ext'];     
    
    // الاحتفاظ بالباسورد القديم لو مدخلش باسور جديد، أو تشفير الجديد
    $password = !empty($_POST['pass']) ? hashPassword($_POST['pass']) : $user['password'];

    $profile_picture = $user['profile_picture']; 

    if (!empty($_FILES['picture']['name'])) {
        $profile_picture = $_FILES['picture']['name'];
        move_uploaded_file($_FILES['picture']['tmp_name'], base_path("public/images/" . $profile_picture));
    }

    // 3. تحديث البيانات باستخدام كلاس الـ Database
    $db->query("UPDATE users SET name = :name, email = :email, password = :password, room_no = :room_no, ext = :ext, profile_picture = :profile_picture WHERE id = :id", [
        'id'              => $id,
        'name'            => $name,
        'email'           => $email,
        'password'        => $password,
        'room_no'         => $room_no,
        'ext'             => $ext,
        'profile_picture' => $profile_picture
    ]);

    redirect('/admin/users');
}

// 4. عرض الصفحة (لاحظ: استخدمت view خاص بالتعديل، لو مش موجود هقولك تعدل إيه في الـ add_user.view)
view('admin/edit_user.view.php', [
    'header' => 'Edit User',
    'user'   => $user
]);
