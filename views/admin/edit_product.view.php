<?php 
/** @var array $product */
/** @var array $categories */
require base_path('views/partials/head.php') ?>
<?php require base_path('views/partials/nav.php') ?>

<style>
   :root {
      --gold: #B8973A;
      --bg: #FDFAF4;
      --card: #FFFFFF;
      --border: rgba(184,151,58,.25);
      --text: #2C2418;
   }
   main { display: flex; justify-content: center; padding: 40px 20px; background: var(--bg); min-height: 100vh; }
   form { width: 100%; max-width: 550px; background: var(--card); padding: 30px; border-radius: 16px; border: 1px solid var(--border); box-shadow: 0 8px 25px rgba(0,0,0,0.08); }
   form h2 { color: var(--gold); margin-bottom: 25px; font-size: 28px; }
   form label { display: block; margin-bottom: 8px; color: var(--text); font-weight: 600; }
   form input, form select { width: 100%; padding: 12px 14px; border: 1px solid var(--border); border-radius: 10px; font-size: 15px; margin-bottom: 20px; box-sizing: border-box; }
   button { padding: 12px 25px; border: none; border-radius: 10px; cursor: pointer; font-weight: 600; background: var(--gold); color: white; }
   .btn-cancel { background: #E8DEC8; color: var(--text); text-decoration: none; padding: 12px 25px; border-radius: 10px; display: inline-block; font-size: 14px; font-weight: 600; }
</style>

<main>
    <form action="/admin/products/edit?id=<?= $product['id'] ?>" method="post" enctype="multipart/form-data">  
        <h2>Edit Product</h2>
        
        <label for="product-name">Product Name</label>
        <input type="text" id="product-name" name="product-name" value="<?= htmlspecialchars($product['name']) ?>" required>
        
        <label for="price">Price (EGP)</label>
        <input type="number" id="price" name="price" step="0.01" value="<?= $product['price'] ?>" required>

        <label for="category">Category</label>
        <select name="category" id="category" required>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category['id'] ?>" <?= $category['id'] == $product['category_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($category['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="status">Status</label>
        <select name="status" id="status">
            <option value="available" <?= $product['status'] == 'available' ? 'selected' : '' ?>>Available</option>
            <option value="unavailable" <?= $product['status'] == 'unavailable' ? 'selected' : '' ?>>Unavailable</option>
        </select>

        <label>Current Image</label>
        <img src="/images/<?= htmlspecialchars($product['image']) ?>" width="80" style="margin-bottom: 10px; border-radius: 5px;">

        <label for="product-picture">Change Image (Optional)</label>
        <input type="file" id="product-picture" name="product-picture">

        <div style="margin-top: 20px; display: flex; gap: 10px;">
            <button type="submit">Update Product</button>
            <a href="/admin/products" class="btn-cancel">Cancel</a>
        </div>
    </form>
</main>

<?php require base_path('views/partials/footer.php') ?>
