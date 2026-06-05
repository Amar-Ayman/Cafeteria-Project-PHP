<?php

// Public Routes
$router->get('/', 'controllers/user/home.php');
$router->get("/login", "controllers/auth/login.php");
$router->post("/login", "controllers/auth/login.php");
$router->get("/forget_password", "controllers/auth/forget_password.php");
$router->post("/logout", "controllers/auth/logout.php");

// Admin Routes
$router->get("/admin/users", "controllers/admin/users.php");
$router->get("/admin/products", "controllers/admin/products.php");
$router->get("/admin/orders", "controllers/admin/orders.php");
$router->get("/admin/checks", "controllers/admin/checks.php");
$router->get("/admin/manual_order", "controllers/admin/manual_order.php");

// User Routes
$router->get("/user/home", "controllers/user/home.php");
$router->get("/user/my_orders", "controllers/user/my_orders.php");
