<?php

use Core\Database;
use Core\Validator;
use Core\Auth;

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validate input
    if (!Validator::email($email)) {
        $errors['email'] = 'Please provide a valid email address.';
    }

    if (!Validator::string($password, 7, 255)) {
        $errors['password'] = 'Please provide a password of at least 7 characters.';
    }

    if (empty($errors)) {
        // Check if user exists
        $user = $db->query('SELECT * FROM users WHERE email = :email', [
            'email' => $email
        ])->find();

        if ($user) {
            // Verify password using bcrypt
            if (verifyPassword($password, $user['password'])) {
                Auth::login($user);
                
                // Redirect based on role
                if ($user['role'] === 'admin') {
                    redirect('/admin/orders');
                } else {
                    redirect('/user/home');
                }
            } else {
                $errors['password'] = 'Incorrect password.';
            }
        } else {
            $errors['email'] = 'No account found with that email address.';
        }
    }
}

view('auth/login.view.php', [
    'errors' => $errors
]);
