<?php
/** @var array $products */
require base_path('views/partials/head.php');
require base_path('views/partials/nav.php');
?>

<style>
    :root {
        --gold: #B8973A;
        --gold-light: #D4AF55;
        --gold-pale: #EDD98A;
        --gold-faint: #F7F0DC;
        --beige: #F5EFE0;
        --beige-dark: #E8DEC8;
        --cream: #FDFAF4;
        --white: #FFFFFF;
        --dark: #1E1A12;
        --text-dark: #2C2418;
        --text-mid: #6B5B3E;
        --text-light: #9E8C6E;
        --shadow: 0 10px 30px rgba(44, 36, 24, 0.08);
        --transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    body { 
        background: radial-gradient(circle at top right, var(--gold-faint), transparent), var(--cream);
        background-attachment: fixed;
        color: var(--text-dark);
        font-family: 'Segoe UI', Roboto, sans-serif;
    }

    .container {
        max-width: 1200px;
        margin: 50px auto;
        padding: 0 20px;
    }

    .header-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 40px;
        background: var(--white);
        padding: 30px 45px;
        border-radius: 25px;
        box-shadow: var(--shadow);
        border: 1px solid var(--beige-dark);
    }

    .header-section h1 {
        color: var(--gold);
        font-size: 36px;
        font-weight: 800;
        margin: 0;
        letter-spacing: -1px;
    }

    .btn-add {
        background: linear-gradient(135deg, var(--dark), #3a3428);
        color: var(--gold-pale);
        padding: 14px 28px;
        border-radius: 15px;
        text-decoration: none;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 12px;
        transition: var(--transition);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        text-transform: uppercase;
        font-size: 14px;
        letter-spacing: 1px;
    }

    .btn-add:hover {
        transform: translateY(-3px);
        background: var(--gold);
        color: white;
        box-shadow: 0 8px 20px rgba(184, 151, 58, 0.3);
    }

    .products-grid-card {
        background: var(--white);
        border-radius: 30px;
        overflow: hidden;
        box-shadow: var(--shadow);
        border: 1px solid var(--beige-dark);
    }

    .product-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .product-table th {
        background: var(--gold-faint);
        color: var(--text-dark);
        padding: 25px;
        font-weight: 800;
        text-transform: uppercase;
        font-size: 13px;
        letter-spacing: 1.5px;
        border-bottom: 2px solid var(--gold-pale);
    }

    .product-table td {
        padding: 25px;
        border-bottom: 1px solid var(--beige);
        vertical-align: middle;
    }

    .product-table tr:hover {
        background-color: rgba(247, 240, 220, 0.4);
    }

    .product-display {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .product-display img {
        width: 90px;
        height: 70px;
        border-radius: 15px;
        object-fit: cover;
        border: 2px solid var(--white);
        box-shadow: 0 8px 15px rgba(0,0,0,0.08);
        transition: var(--transition);
    }

    .product-display:hover img {
        transform: scale(1.1) rotate(2deg);
    }

    .product-name {
        font-weight: 800;
        color: var(--text-dark);
        font-size: 18px;
    }

    .price-tag {
        font-weight: 700;
        color: var(--gold);
        font-size: 18px;
        background: var(--gold-faint);
        padding: 8px 15px;
        border-radius: 12px;
        display: inline-block;
    }

    .action-btns {
        display: flex;
        gap: 12px;
    }

    .btn-action {
        width: 45px;
        height: 45px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: var(--transition);
        font-size: 18px;
        border: none;
        cursor: pointer;
    }

    .btn-edit {
        background: var(--beige);
        color: var(--text-dark);
    }

    .btn-edit:hover {
        background: var(--gold-light);
        color: white;
        transform: translateY(-3px);
    }

    .btn-delete {
        background: #FFF5F5;
        color: #E05252;
    }

    .btn-delete:hover {
        background: #E05252;
        color: white;
        transform: translateY(-3px);
    }

    /* SweetAlert2 Custom Styling */
    .swal2-popup {
        border-radius: 25px !important;
        padding: 2rem !important;
    }
    .swal2-title { color: var(--text-dark) !important; }
    .swal2-confirm { background: var(--gold) !important; border-radius: 12px !important; }
    .swal2-cancel { background: var(--beige-dark) !important; color: var(--text-dark) !important; border-radius: 12px !important; }
</style>

<!-- FontAwesome & SweetAlert2 -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<main class="container">
    <div class="header-section">
        <div>
            <h1>Café Menu</h1>
            <p style="color: var(--text-light); margin: 5px 0 0 0;">Manage your delicious products and pricing</p>
        </div>
        <a href="/admin/products/add" class="btn-add">
            <i class="fas fa-plus-circle"></i> Add New Product
        </a>
    </div>

    <div class="products-grid-card">
        <table class="product-table">
            <thead>
                <tr>
                    <th>Product Details</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($products as $product): ?>
                <tr>
                    <td>
                        <div class="product-display">
                            <img src="/images/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                            <span class="product-name"><?= htmlspecialchars($product['name']) ?></span>
                        </div>
                    </td>
                    <td>
                        <span class="price-tag"><?= number_format($product['price'], 2) ?> <small>EGP</small></span>
                    </td>
                    <td>
                        <span style="color: #27ae60; font-weight: 700;">
                            <i class="fas fa-check-circle"></i> In Stock
                        </span>
                    </td>
                    <td>
                        <div class="action-btns">
                            <a href="/admin/products/edit?id=<?= $product['id'] ?>" class="btn-action btn-edit" title="Edit Product">
                                <i class="fas fa-pen-nib"></i>
                            </a>
                            <button type="button" class="btn-action btn-delete" title="Delete Product" 
                                    onclick="confirmDelete('<?= $product['id'] ?>', '<?= htmlspecialchars($product['name']) ?>')">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>

<script>
    function confirmDelete(productId, productName) {
        Swal.fire({
            title: 'Remove Product?',
            text: `Are you sure you want to remove "${productName}" from the menu?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#B8973A',
            cancelButtonColor: '#E8DEC8',
            confirmButtonText: 'Yes, remove it',
            cancelButtonText: 'Keep it',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `/admin/products?action=delete&id=${productId}`;
            }
        })
    }
</script>

<?php require base_path('views/partials/footer.php') ?>