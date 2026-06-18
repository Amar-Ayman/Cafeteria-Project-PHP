<?php

use Core\Database;

class ManualOrderController
{
    private $conn;

    public function __construct()
    {
        authorize(isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin');
        
        $config = require base_path('config.php');
        $db = new Database($config['database']);
        $this->conn = $db->connection;
    }

    public function index()
    {
        view('admin/manual_order.view.php');
    }

    public function getData()
    {
        try {
            // Get Users
            $stmt = $this->conn->query("SELECT id, name, email, room_no as room_number, ext FROM users WHERE role = 'user'");
            $users = $stmt->fetchAll();

            // Get Products
            $stmt = $this->conn->query("
                SELECT p.id, p.name, p.price, p.image, p.status, c.name as category_name 
                FROM products p 
                JOIN categories c ON p.category_id = c.id
            ");
            $products = $stmt->fetchAll();
            
            foreach ($products as &$p) {
                $p['is_available'] = ($p['status'] === 'available') ? 1 : 0;
                if ($p['image']) {
                    $p['image'] = '/images/' . $p['image'];
                }
            }

            // Get Rooms
            $stmt = $this->conn->query("SELECT DISTINCT room_no as room_number FROM users WHERE room_no IS NOT NULL AND room_no != ''");
            $roomsRaw = $stmt->fetchAll();
            $rooms = [];
            foreach ($roomsRaw as $index => $r) {
                $rooms[] = ['id' => $r['room_number'], 'room_number' => $r['room_number']];
            }

            echo json_encode([
                'success' => true,
                'users' => $users,
                'products' => $products,
                'rooms' => $rooms
            ]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function create()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!$data || empty($data['items'])) {
            echo json_encode(['success' => false, 'message' => 'No items in cart']);
            return;
        }

        try {
            $this->conn->beginTransaction();

            $items = $data['items'];
            $total_amount = 0;
            
            foreach ($items as $item) {
                $stmt = $this->conn->prepare("SELECT price FROM products WHERE id = ?");
                $stmt->execute([$item['product_id']]);
                $product = $stmt->fetch();
                if ($product) {
                    $total_amount += $product['price'] * $item['quantity'];
                }
            }

            $stmt = $this->conn->prepare(
                "INSERT INTO orders (user_id, total_amount, status, room, notes, order_date) 
                 VALUES (?, ?, 'processing', ?, ?, NOW())"
            );

            $stmt->execute([
                $data['user_id'],
                $total_amount,
                $data['room_id'],
                $data['notes'] ?? ''
            ]);

            $order_id = $this->conn->lastInsertId();

            $stmt = $this->conn->prepare(
                "INSERT INTO order_items (order_id, product_id, quantity, price) 
                 VALUES (?, ?, ?, ?)"
            );

            foreach ($items as $item) {
                $pStmt = $this->conn->prepare("SELECT price FROM products WHERE id = ?");
                $pStmt->execute([$item['product_id']]);
                $product = $pStmt->fetch();

                if ($product) {
                    $stmt->execute([
                        $order_id,
                        $item['product_id'],
                        $item['quantity'],
                        $product['price']
                    ]);
                }
            }

            $this->conn->commit();
            echo json_encode([
                'success' => true, 
                'order_id' => $order_id, 
                'total' => $total_amount
            ]);

        } catch (Exception $e) {
            if ($this->conn->inTransaction()) {
                $this->conn->rollBack();
            }
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}

$controller = new ManualOrderController();
$action = $_GET['action'] ?? 'index';

if ($action === 'get_data') {
    $controller->getData();
} elseif ($action === 'create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->create();
} else {
    $controller->index();
}
