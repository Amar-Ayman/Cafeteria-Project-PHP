<?php

use Core\Database;
use Core\Response;

// Ensure only admin can access this page
authorize(isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin');

class AdminOrderController
{
    private $db;

    public function __construct()
    {
        $config = require base_path('config.php');
        $this->db = new Database($config['database']);
    }

    public function index()
    {
        // Fetch all orders with user information
        $orders = $this->db->query("
            SELECT 
                o.id, 
                u.name as user_name, 
                o.total_amount, 
                o.status, 
                o.room, 
                o.notes, 
                o.order_date
            FROM orders o
            JOIN users u ON o.user_id = u.id
            ORDER BY o.order_date DESC
        ")->get();

        // Initialize variables to avoid "undefined variable" errors in view
        $selectedOrder = null;
        $orderItems = [];
        
        if (isset($_GET['id'])) {
            $selectedOrder = $this->db->query("
                SELECT o.*, u.name as user_name, u.room_no as user_room_no, u.ext as user_ext
                FROM orders o 
                JOIN users u ON o.user_id = u.id 
                WHERE o.id = :id
            ", [':id' => $_GET['id']])->find();

            if ($selectedOrder) {
                $orderItems = $this->db->query("
                    SELECT oi.*, p.name as product_name 
                    FROM order_items oi 
                    JOIN products p ON oi.product_id = p.id 
                    WHERE oi.order_id = :order_id
                ", [':order_id' => $_GET['id']])->get();
            }
        }

        // Changed view name to order.view.php as requested
        view('admin/order.view.php', [
            'orders' => $orders,
            'selectedOrder' => $selectedOrder,
            'orderItems' => $orderItems
        ]);
    }

    public function updateStatus()
    {
        $order_id = $_POST['order_id'] ?? null;
        $status = $_POST['status'] ?? null;

        if ($order_id && $status) {
            $this->db->query("
                UPDATE orders SET status = :status WHERE id = :id
            ", [
                ':status' => $status,
                ':id' => $order_id
            ]);
        }

        redirect('/admin/orders');
    }

    public function destroy()
    {
        $order_id = $_POST['order_id'] ?? null;

        if ($order_id) {
            $this->db->query("DELETE FROM orders WHERE id = :id", [':id' => $order_id]);
        }

        redirect('/admin/orders');
    }
}

$controller = new AdminOrderController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['_method']) && $_POST['_method'] === 'PATCH') {
        $controller->updateStatus();
    } elseif (isset($_POST['_method']) && $_POST['_method'] === 'DELETE') {
        $controller->destroy();
    } else {
        redirect('/admin/orders');
    }
} else {
    $controller->index();
}
