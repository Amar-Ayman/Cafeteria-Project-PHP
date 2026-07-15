<?php 
/** @var array $product */
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
        background: radial-gradient(circle at top left, var(--gold-faint), transparent),
                    radial-gradient(circle at bottom right, var(--beige), transparent),
                    var(--cream);
        background-attachment: fixed;
        color: var(--text-dark);
        font-family: 'Segoe UI', Roboto, sans-serif;
    }

    main { display: flex; justify-content: center; align-items: center; padding: 80px 20px; min-height: 90vh; }

    .form-card {
        width: 100%; max-width: 600px; background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(15px); padding: 50px; border-radius: 30px; 
        border: 1px solid rgba(184, 151, 58, 0.25); box-shadow: var(--shadow);
        position: relative;
    }

    .form-header { margin-bottom: 35px; text-align: center; }
    .form-header h2 { color: var(--gold); font-size: 38px; font-weight: 800; }

    .preview-box {
        display: flex; align-items: center; gap: 20px; margin-bottom: 30px;
        background: linear-gradient(135deg, var(--gold-faint), var(--beige));
        padding: 20px; border-radius: 20px; border: 1px solid var(--gold-pale);
    }
    .preview-box img {
        width: 100px; height: 80px; border-radius: 15px; object-fit: cover;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1); border: 3px solid var(--white);
    }
    .preview-box .info { display: flex; flex-direction: column; }
    .preview-box .info .label { font-size: 12px; color: var(--gold); font-weight: 800; text-transform: uppercase; }
    .preview-box .info .name { font-size: 18px; color: var(--text-dark); font-weight: 700; }

    .form-group { margin-bottom: 25px; position: relative; }
    .form-group label { 
        display: block; margin-bottom: 10px; color: var(--text-dark); 
        font-weight: 700; font-size: 13px; text-transform: uppercase; letter-spacing: 1.2px; 
    }
    
    .form-control {
        width: 100%; padding: 16px 20px; border: 2px solid var(--beige-dark); border-radius: 15px;
        background: var(--white); color: var(--text-dark); font-size: 16px; 
        transition: var(--transition); box-sizing: border-box;
        -webkit-appearance: none; -moz-appearance: none; appearance: none;
    }

    .form-control:focus { outline: none; border-color: var(--gold); transform: translateY(-2px); }

    /* Custom Select Styling */
    .select-wrapper { position: relative; }
    .select-wrapper::after {
        content: "\f0d7"; font-family: "Font Awesome 5 Free"; font-weight: 900;
        position: absolute; right: 20px; top: 50%; transform: translateY(-50%);
        color: var(--gold); pointer-events: none; font-size: 18px;
    }

    /* Price Input Fix */
    .price-group { position: relative; display: flex; align-items: center; }
    .price-group input { padding-right: 70px !important; }
    .price-group .currency-badge {
        position: absolute; right: 15px; background: var(--gold-faint);
        color: var(--gold); padding: 6px 12px; border-radius: 10px;
        font-weight: 800; font-size: 12px; border: 1px solid var(--gold-pale);
    }

    /* Hide Number Arrows */
    input::-webkit-outer-spin-button, input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
    input[type=number] { -moz-appearance: textfield; }

    .upload-zone {
        border: 2px dashed var(--gold-pale); border-radius: 20px; padding: 25px;
        text-align: center; background: var(--gold-faint); cursor: pointer;
        transition: var(--transition); position: relative;
    }
    .upload-zone:hover { background: var(--white); border-color: var(--gold); }
    .upload-zone i { font-size: 30px; color: var(--gold); margin-bottom: 10px; }
    .upload-zone p { margin: 0; font-weight: 700; color: var(--text-mid); font-size: 14px; }
    .upload-zone input { position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer; }

    .actions { margin-top: 45px; display: flex; gap: 20px; }
    .btn {
        flex: 1; padding: 18px; border: none; border-radius: 15px; font-weight: 800; font-size: 16px;
        cursor: pointer; transition: var(--transition); text-decoration: none; text-align: center;
        text-transform: uppercase;
    }
    .btn-primary { background: var(--dark); color: var(--gold-pale); }
    .btn-primary:hover { background: var(--gold); color: white; transform: translateY(-3px); }
    .btn-secondary { background: var(--beige-dark); color: var(--text-dark); }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<main>
    <div class="form-card">
        <div class="form-header">
            <h2>Edit Product</h2>
        </div>

        <div class="preview-box">
            <img src="/images/<?= htmlspecialchars($product['image']) ?>" alt="Product">
            <div class="info">
                <span class="label">Current Item</span>
                <span class="name"><?= htmlspecialchars($product['name']) ?></span>
            </div>
        </div>

        <form action="/admin/products/edit?id=<?= $product['id'] ?>" method="post" enctype="multipart/form-data">  
            <div class="form-group">
                <label for="product-name">Product Name</label>
                <input type="text" id="product-name" name="product-name" class="form-control" value="<?= htmlspecialchars($product['name']) ?>" required>
            </div>
            
            <div class="form-group">
                <label for="price">Price</label>
                <div class="price-group">
                    <input type="number" id="price" name="price" class="form-control" step="0.01" value="<?= $product['price'] ?>" required>
                    <span class="currency-badge">EGP</span>
                </div>
            </div>

            <div class="form-group">
                <label for="category">Category</label>
                <div class="select-wrapper">
                    <select name="category" id="category" class="form-control" required>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['id'] ?>" <?= $category['id'] == $product['category_id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($category['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="status">Availability</label>
                <div class="select-wrapper">
                    <select name="status" id="status" class="form-control">
                        <option value="available" <?= $product['status'] == 'available' ? 'selected' : '' ?>>Available</option>
                        <option value="unavailable" <?= $product['status'] == 'unavailable' ? 'selected' : '' ?>>Unavailable</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Change Image</label>
                <div class="upload-zone">
                    <i class="fas fa-camera"></i>
                    <p>Click to upload new image</p>
                    <input type="file" name="product-picture" accept="image/*" onchange="showName(this)">
                    <div id="name-display" style="margin-top: 10px; color: var(--gold); font-weight: 800; font-size: 12px;"></div>
                </div>
            </div>

            <div class="actions">
                <button type="submit" class="btn btn-primary">Update Product</button>
                <a href="/admin/products" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</main>

<script>
    function showName(input) {
        if(input.files.length > 0) {
            document.getElementById('name-display').textContent = "✓ " + input.files[0].name;
        }
    }
</script>

<?php require base_path('views/partials/footer.php') ?>