
<?php

use Core\Database;

// Ensure user is logged in
authorize(isset($_SESSION['user']));

class UserProductsController
{
    private $db;

    public function __construct()
    {
        $config = require base_path('config.php');
        $this->db = new Database($config['database']);
    }

    public function index()
    {
        // Fetch all categories
        $categories = $this->db->query("SELECT * FROM categories")->get();

        // Base query for available products
        $query = "
            SELECT p.*, c.name as category_name 
            FROM products p
            JOIN categories c ON p.category_id = c.id
            WHERE p.status = 'available'
        ";

        $params = [];
        
        // Filter by category if provided in URL
        if (isset($_GET['category']) && !empty($_GET['category'])) {
            $query .= " AND p.category_id = :category_id";
            $params[':category_id'] = $_GET['category'];
        }
        
        // Search by product name if provided
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $query .= " AND p.name LIKE :search";
            $params[':search'] = "%" . $_GET['search'] . "%";
        }

        $products = $this->db->query($query, $params)->get();

        view('user/products.view.php', [
            'products' => $products,
            'categories' => $categories
        ]);
    }
}

$controller = new UserProductsController();
$controller->index();