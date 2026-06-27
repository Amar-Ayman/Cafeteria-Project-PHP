<?php
use Core\Database;
use Core\Auth;

authorize(Auth::check() && $_SESSION['user']['role'] === 'admin');

$config = require base_path('config.php');
$db = new Database($config['database']);
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // 1. التأكد إن الإيميل مش مكرر
    $user = $db->query("SELECT * FROM users WHERE email = :email", ['email' => $email])->find();

    if ($user) {
        $errors['email'] = 'This email is already registered!';
    } else {
        // 2. لو مش مكرر، كمل عملية الإضافة عادي
        $name     = $_POST['name'];
        $room_no  = $_POST['Room_No']; 
        $ext      = $_POST['Ext'];     
        $password = hashPassword($_POST['pass']); // Hash password using bcrypt 
        $profile_picture = 'default.jpeg'; 

        if (!empty($_FILES['picture']['name'])) {
            $profile_picture = $_FILES['picture']['name'];
            move_uploaded_file($_FILES['picture']['tmp_name'], base_path("public/images/" . $profile_picture));
        }

        $db->query("INSERT INTO users (name, email, password, room_no, ext, profile_picture, role) 
                    VALUES (:name, :email, :password, :room_no, :ext, :profile_picture, :role)", [
            'name'            => $name,
            'email'           => $email,
            'password'        => $password,
            'room_no'         => $room_no,
            'ext'             => $ext,
            'profile_picture' => $profile_picture,
            'role'            => 'user'
        ]);

        redirect('/admin/users');
    }
}

view('admin/add_user.view.php', [
    'header' => 'Add User',
    'errors' => $errors
]);
