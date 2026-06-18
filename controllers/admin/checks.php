<?php

use Core\Database;

class ChecksController
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
        $dateFrom = $_GET['date_from'] ?? '';
        $dateTo = $_GET['date_to'] ?? '';
        $userId = $_GET['user_id'] ?? '';

        $users = $this->getSummaryData($dateFrom, $dateTo, $userId);
        $kpis = $this->getKPIData($dateFrom, $dateTo, $userId);
        $allUsers = $this->conn->query("SELECT id, name FROM users WHERE role = 'user'")->fetchAll();

        view('admin/checks.view.php', [
            'users' => $users,
            'allUsers' => $allUsers,
            'kpis' => $kpis,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'selectedUserId' => $userId
        ]);
    }

    private function getSummaryData($from, $to, $userId)
    {
        $query = "
            SELECT u.id, u.name, u.email, u.ext, u.room_no as room_number, 
                   COUNT(o.id) as total_orders, 
                   IFNULL(SUM(o.total_amount), 0) as total_amount,
                   MAX(o.order_date) as last_order_date
            FROM users u
            LEFT JOIN orders o ON u.id = o.user_id
            WHERE u.role = 'user'
        ";

        $params = [];
        if ($from) { $query .= " AND o.order_date >= ?"; $params[] = $from . ' 00:00:00'; }
        if ($to) { $query .= " AND o.order_date <= ?"; $params[] = $to . ' 23:59:59'; }
        if ($userId) { $query .= " AND u.id = ?"; $params[] = $userId; }

        $query .= " GROUP BY u.id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    private function getKPIData($from, $to, $userId)
    {
        $query = "SELECT SUM(total_amount) as revenue, COUNT(id) as total_orders, COUNT(DISTINCT user_id) as active_users FROM orders WHERE 1=1";
        $params = [];
        if ($from) { $query .= " AND order_date >= ?"; $params[] = $from . ' 00:00:00'; }
        if ($to) { $query .= " AND order_date <= ?"; $params[] = $to . ' 23:59:59'; }
        if ($userId) { $query .= " AND user_id = ?"; $params[] = $userId; }

        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        $res = $stmt->fetch();

        return [
            'revenue' => $res['revenue'] ?? 0,
            'total_orders' => $res['total_orders'] ?? 0,
            'active_users' => $res['active_users'] ?? 0,
            'avg_order' => ($res['total_orders'] > 0) ? ($res['revenue'] / $res['total_orders']) : 0
        ];
    }

    public function summary()
    {
        $from = $_GET['date_from'] ?? '';
        $to = $_GET['date_to'] ?? '';
        $userId = $_GET['user_id'] ?? '';
        
        $users = $this->getSummaryData($from, $to, $userId);
        echo json_encode(['success' => true, 'users' => $users]);
    }

    public function kpis()
    {
        $from = $_GET['date_from'] ?? '';
        $to = $_GET['date_to'] ?? '';
        $userId = $_GET['user_id'] ?? '';
        
        $kpis = $this->getKPIData($from, $to, $userId);
        echo json_encode(['success' => true, 'kpis' => $kpis]);
    }

    public function userDetail()
    {
        $userId = $_GET['user_id'] ?? '';
        $from = $_GET['date_from'] ?? '';
        $to = $_GET['date_to'] ?? '';

        if (!$userId) {
            echo json_encode(['success' => false, 'message' => 'User ID required']);
            return;
        }

        $stmt = $this->conn->prepare("SELECT id, name, email, room_no as room_number, ext FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch();

        $query = "SELECT id, total_amount as total, order_date as created_at, status FROM orders WHERE user_id = ?";
        $params = [$userId];
        if ($from) { $query .= " AND order_date >= ?"; $params[] = $from . ' 00:00:00'; }
        if ($to) { $query .= " AND order_date <= ?"; $params[] = $to . ' 23:59:59'; }
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        $orders = $stmt->fetchAll();

        foreach ($orders as &$o) {
            $stmt = $this->conn->prepare("
                SELECT p.name as product_name, oi.quantity 
                FROM order_items oi 
                JOIN products p ON oi.product_id = p.id 
                WHERE oi.order_id = ?
            ");
            $stmt->execute([$o['id']]);
            $o['items'] = $stmt->fetchAll();
            
            if ($o['status'] === 'out for delivery') $o['status'] = 'delivery';
        }

        $stats = [
            'total_orders' => count($orders),
            'total_amount' => array_sum(array_column($orders, 'total'))
        ];

        echo json_encode(['success' => true, 'user' => $user, 'orders' => $orders, 'stats' => $stats]);
    }
}

$controller = new ChecksController();
$action = $_GET['action'] ?? 'index';

if ($action === 'summary') {
    $controller->summary();
} elseif ($action === 'kpis') {
    $controller->kpis();
} elseif ($action === 'user_detail') {
    $controller->userDetail();
} else {
    $controller->index();
}
