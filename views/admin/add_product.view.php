<?php 
/** @var array $categories */
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
        --shadow: 0 20px 40px rgba(44, 36, 24, 0.12);
        --transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    body { 
        margin: 0;
        background: radial-gradient(circle at top right, var(--gold-faint), transparent),
                    radial-gradient(circle at bottom left, var(--beige), transparent),
                    var(--cream);
        background-attachment: fixed;
        color: var(--text-dark);
        font-family: 'Segoe UI', Roboto, sans-serif;
    }

    main { 
        display: flex; justify-content: center; align-items: center; 
        padding: 80px 20px; min-height: 90vh; 
    }

    .form-card {
        width: 100%; max-width: 600px; 
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        padding: 50px;
        border-radius: 30px; 
        border: 1px solid rgba(184, 151, 58, 0.2); 
        box-shadow: var(--shadow);
        position: relative;
    }

    .form-card::after {
        content: ""; position: absolute; top: -2px; left: -2px; right: -2px; bottom: -2px;
        background: linear-gradient(135deg, var(--gold-pale), transparent, var(--beige-dark));
        z-index: -1; border-radius: 32px;
    }

    .form-header { margin-bottom: 40px; text-align: center; }
    .form-header h2 { 
        color: var(--gold); font-size: 36px; font-weight: 800; margin-bottom: 12px; 
        letter-spacing: -1px;
    }
    .form-header p { color: var(--text-mid); font-size: 16px; font-weight: 500; }

    .form-group { margin-bottom: 25px; }
    .form-group label { 
        display: block; margin-bottom: 10px; color: var(--text-dark); 
        font-weight: 700; font-size: 13px; text-transform: uppercase; letter-spacing: 1px; 
    }
    
    .form-control {
        width: 100%; padding: 16px 20px; border: 2px solid var(--beige-dark); border-radius: 15px;
        background: rgba(255, 255, 255, 0.8); color: var(--text-dark); font-size: 16px; 
        transition: var(--transition); box-sizing: border-box;
    }

    .form-control:focus { 
        outline: none; border-color: var(--gold); 
        background: var(--white); box-shadow: 0 10px 20px rgba(184, 151, 58, 0.1);
        transform: translateY(-2px);
    }

    /* Price Input Fix */
    .price-group { position: relative; display: flex; align-items: center; }
    .price-group .currency-badge {
        position: absolute; right: 15px; background: var(--gold-faint);
        color: var(--gold); padding: 6px 12px; border-radius: 10px;
        font-weight: 800; font-size: 12px; border: 1px solid var(--gold-pale);
    }

    /* Custom File Upload */
    .file-upload-wrapper {
        position: relative; width: 100%; height: 120px;
        border: 2px dashed var(--gold-pale); border-radius: 15px;
        display: flex; flex-direction: column; justify-content: center; align-items: center;
        background: var(--gold-faint); transition: var(--transition); cursor: pointer;
        overflow: hidden;
    }

    .file-upload-wrapper:hover {
        background: var(--white); border-color: var(--gold);
        box-shadow: 0 10px 20px rgba(184, 151, 58, 0.1);
    }

    .file-upload-wrapper i { font-size: 30px; color: var(--gold); margin-bottom: 10px; }
    .file-upload-wrapper span { font-size: 14px; color: var(--text-mid); font-weight: 600; }
    .file-upload-wrapper input[type="file"] {
        position: absolute; top: 0; left: 0; width: 100%; height: 100%;
        opacity: 0; cursor: pointer;
    }

    .actions { margin-top: 45px; display: flex; gap: 20px; }

    .btn {
        flex: 1; padding: 18px; border: none; border-radius: 15px; font-weight: 800; font-size: 16px;
        cursor: pointer; transition: var(--transition); text-decoration: none; text-align: center;
        text-transform: uppercase; letter-spacing: 1px;
    }

    .btn-primary { 
        background: linear-gradient(135deg, var(--dark), #3a3428); 
        color: var(--gold-pale); 
        box-shadow: 0 10px 20px rgba(0,0,0,0.15); 
    }
    .btn-primary:hover { 
        transform: translateY(-3px); box-shadow: 0 15px 30px rgba(0,0,0,0.2); 
        background: linear-gradient(135deg, var(--gold), var(--gold-light));
        color: white;
    }

    .btn-secondary { background: var(--beige-dark); color: var(--text-dark); }
    .btn-secondary:hover { background: var(--beige); transform: translateY(-3px); }

    @media (max-width: 480px) { .actions { flex-direction: column; } }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<main>
    <div class="form-card">
        <div class="form-header">
            <h2>Add Product</h2>
            <p>Craft a new experience for your customers</p>
        </div>

        <form action="/admin/products/add" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="product-name">Product Name</label>
                <input type="text" id="product-name" name="product-name" class="form-control" placeholder="Enter product name" required>
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <div class="price-group">
                    <input type="number" id="price" name="price" class="form-control" step="0.01" min="1" placeholder="0.00" required>
                    <span class="currency-badge">EGP</span>
                </div>
            </div>

            <div class="form-group">
                <label for="category">Category</label>
                <select name="category" id="category" class="form-control" required>
                    <option value="" disabled selected>Select Category</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Product Image</label>
                <div class="file-upload-wrapper">
                    <i class="fas fa-mug-hot"></i>
                    <span>Click to upload product image</span>
                    <input type="file" name="product-picture" accept="image/*" required onchange="updateFileName(this)">
                    <small id="file-name" style="margin-top: 10px; color: var(--gold); font-weight: bold;"></small>
                </div>
            </div>

            <div class="actions">
                <button type="submit" class="btn btn-primary">Save Product</button>
                <a href="/admin/products" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</main>

<script>
    function updateFileName(input) {
        if(input.files.length > 0) {
            document.getElementById('file-name').textContent = "✓ Selected: " + input.files[0].name;
        }
    }
</script>

<?php require base_path('views/partials/footer.php'); ?>
