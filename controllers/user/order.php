<?php

use Core\Database;

class OrderController
{
    private $conn;

    public function __construct()
    {
        // Check if user is logged in (matching your session key)
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit();
        }

        $config = require base_path('config.php');
        $db = new Database($config['database']);
        $this->conn = $db->connection;
    }

    public function store()
    {
        // Get JSON data from request body
        $data = json_decode(file_get_contents("php://input"), true);

        if (!$data || empty($data['items'])) {
            echo "Error: No items in cart";
            return;
        }

        try {
            // Start Transaction to ensure all items are saved or none
            $this->conn->beginTransaction();

            $items = $data['items'];
            $total_amount = 0;
            
            // 1. Calculate total amount by verifying prices from DB
            foreach ($items as $item) {
                $stmt = $this->conn->prepare("SELECT price FROM products WHERE id = ?");
                $stmt->execute([$item['id']]);
                $product = $stmt->fetch();
                
                if ($product) {
                    $total_amount += $product['price'] * $item['quantity'];
                }
            }

            // 2. Create the main Order Record
            // Matching your DB columns: user_id, total_amount, status, room, notes
            $stmt = $this->conn->prepare(
                "INSERT INTO orders (user_id, total_amount, status, room, notes, order_date) 
                 VALUES (?, ?, ?, ?, ?, NOW())"
            );

            $stmt->execute([
                $_SESSION['user']['id'],
                $total_amount,
                'processing', // Initial status
                $data['room'], // This contains the location info from the view
                $data['notes'] ?? ''
            ]);

            $order_id = $this->conn->lastInsertId();

            // 3. Create Order Items Records
            $stmt = $this->conn->prepare(
                "INSERT INTO order_items (order_id, product_id, quantity, price) 
                 VALUES (?, ?, ?, ?)"
            );

            foreach ($items as $item) {
                // Fetch fresh price from DB for security
                $pStmt = $this->conn->prepare("SELECT price FROM products WHERE id = ?");
                $pStmt->execute([$item['id']]);
                $product = $pStmt->fetch();

                if ($product) {
                    $stmt->execute([
                        $order_id,
                        $item['id'],
                        $item['quantity'],
                        $product['price']
                    ]);
                }
            }

            // Commit transaction if everything is fine
            $this->conn->commit();
            echo "success";

        } catch (Exception $e) {
            // Rollback on error
            if ($this->conn->inTransaction()) {
                $this->conn->rollBack();
            }
            echo "Error: " . $e->getMessage();
        }
    }

    public function index()
    {
        view('user/order.view.php', []);
    }
}

$controller = new OrderController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->store();
} else {
    $controller->index();
}
