<?php

use Core\Database;
use Core\Validator;

//If user already is logined
if(isset($_SESSION['user'])){
    //admin --> redirect order page
    if($_SESSION['user']['role'] === 'admin'){
        header('location : /admin/orders');
    }
    else{
        header('location: /user/home');
    }
}

$config = require base_path('config.php');
$db = new Database($config['database']);

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';

    // Validate input
    if (!Validator::email($email)) {
        $errors['email'] = 'Please provide a valid email address.';
    }

    if (empty($errors)) {
        // Check if user exists
        $user = $db->query('SELECT * FROM users WHERE email = :email', [
            'email' => $email
        ])->find();

        if ($user) {
            $success = 'If an account with that email exists, a password reset link has been sent.';
        } else {
            $success = 'If an account with that email exists, a password reset link has been sent.';
        }
    }
}

view('auth/forget_password.view.php', [
    'errors' => $errors,
    'success' => $success
]);
