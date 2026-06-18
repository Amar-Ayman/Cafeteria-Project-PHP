<?php

// Public Routes
$router->get('/', 'controllers/auth/login.php');
$router->get("/login", "controllers/auth/login.php");
$router->post("/login", "controllers/auth/login.php");
$router->get("/forget_password", "controllers/auth/forget_password.php");
$router->post("/forget_password", "controllers/auth/forget_password.php");
$router->post("/logout", "controllers/auth/logout.php");

// Admin Routes
$router->get("/admin/users", "controllers/admin/users.php");
$router->get("/admin/users/add", "controllers/admin/add_user.php");
$router->post("/admin/users/add", "controllers/admin/add_user.php");
$router->get("/admin/users/edit", "controllers/admin/edit_user.php");
$router->post("/admin/users/edit", "controllers/admin/edit_user.php");

$router->get("/admin/products", "controllers/admin/products.php");
$router->get("/admin/products/add", "controllers/admin/add_product.php");
$router->post("/admin/products/add", "controllers/admin/add_product.php");
$router->get("/admin/products/edit", "controllers/admin/edit_product.php");
$router->post("/admin/products/edit", "controllers/admin/edit_product.php");
$router->get("/admin/orders", "controllers/admin/orders.php");
$router->patch("/admin/orders", "controllers/admin/orders.php");
$router->delete("/admin/orders", "controllers/admin/orders.php");
$router->get("/admin/order", "controllers/admin/orders.php");
$router->get("/admin/checks", "controllers/admin/checks.php");
$router->get("/admin/manual_order", "controllers/admin/manual_order.php");
$router->post("/admin/manual_order", "controllers/admin/manual_order.php");

$router->get("/user/home", "controllers/user/home.php");
$router->get("/user/my_orders", "controllers/user/my_orders.php");
$router->get('/user/products', 'controllers/user/products.php');
$router->get("/order", 'controllers/user/order.php');
$router->post('/user/order/store', 'controllers/user/order.php');