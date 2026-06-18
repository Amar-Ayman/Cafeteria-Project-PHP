<?php
/** @var array $products */
 require base_path('views/partials/head.php') ?>
<?php require base_path('views/partials/nav.php') ?>

<style>
   :root {
      --gold:        #B8973A;
      --gold-lt:     #D4AF55;
      --bg:          #FDFAF4;
      --surface:     #F5EFE0;
      --card:        #FFFFFF;
      --border:    rgba(184,151,58,.25);
      --text:        #2C2418;
      --red:       #E05252;
      --blue:      #4A90D9;
      --dark:      #1E1A12;
   }
   .product-container {
    max-width: 1200px;
    margin: 40px auto;
    padding: 0 20px;
   }
   .product-header-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
   }
   .product-header-section h1 {
    color: var(--dark);
    font-size: 2rem;
    font-family: 'Cormorant Garamond', serif;
   }
   .btn-add {
    background: var(--gold);
    color: white;
    padding: 12px 20px;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 600;
    transition: 0.3s;
   }
   .btn-add:hover {
    background: var(--dark);
   }
   .product-table {
    width: 100%;
    border-collapse: collapse;
    background: var(--card);
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
   }
   .product-table th {
    background: var(--surface);
    color: var(--gold);
    padding: 15px;
    text-align: left;
    border-bottom: 2px solid var(--gold);
   }
   .product-table td {
    padding: 15px;
    border-bottom: 1px solid var(--bg);
    vertical-align: middle;
   }
   .product-table img {
    border-radius: 8px;
    object-fit: cover;
   }
   .action-btns {
    display: flex;
    gap: 10px;
   }
   .btn-edit {
    background: var(--blue);
    color: white;
    padding: 8px 15px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 14px;
   }
   .btn-delete {
    background: var(--red);
    color: white;
    padding: 8px 15px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 14px;
   }
</style>

<main class="product-container">
    <div class="product-header-section">
        <h1>All Products</h1>
        <a href="/admin/products/add" class="btn-add">Add New Product</a>
    </div>

    <table class="product-table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($products as $product): ?>
            <tr>
                <td style="font-weight: 600;"><?= htmlspecialchars($product['name']) ?></td>
                <td><?= number_format($product['price'], 2) ?> EGP</td>
                <td>
                    <img src="/images/<?= htmlspecialchars($product['image']) ?>" 
                         width="80" height="60" alt="<?= htmlspecialchars($product['name']) ?>">
                </td>
                <td>
                    <div class="action-btns">
                        <a href="/admin/products/edit?id=<?= $product['id'] ?>" class="btn-edit">Edit</a>
                        <a href="/admin/products?action=delete&id=<?= $product['id'] ?>" 
                           class="btn-delete" 
                           onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>

<?php require base_path('views/partials/footer.php') ?>
