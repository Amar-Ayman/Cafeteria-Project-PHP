<?php 
/** @var array $categories */
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
      --muted:       #6B5B3E;
      --beige-dk:  #E8DEC8;
   }
   main {
    display: flex;
    justify-content: center;
    padding: 40px 20px;
    background: var(--bg);
    min-height: 100vh;
}

form {
    width: 100%;
    max-width: 550px;
    background: var(--card);
    padding: 30px;
    border-radius: 16px;
    border: 1px solid var(--border);
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
}

form h2 {
    color: var(--gold);
    margin-bottom: 25px;
    font-size: 28px;
}

form label {
    display: block;
    margin-bottom: 8px;
    color: var(--text);
    font-weight: 600;
}

form input,
form select {
    width: 100%;
    padding: 12px 14px;
    border: 1px solid var(--border);
    border-radius: 10px;
    background: var(--surface);
    color: var(--text);
    font-size: 15px;
    margin-bottom: 20px;
    box-sizing: border-box;
}

form input:focus,
form select:focus {
    outline: none;
    border-color: var(--gold);
}

.currency {
    color: var(--muted);
    font-size: 14px;
    margin-left: 5px;
}

button {
    padding: 12px 25px;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    font-weight: 600;
    transition: 0.3s;
}

button[type="submit"] {
    background: var(--gold);
    color: white;
}

button[type="submit"]:hover {
    background: var(--gold-lt);
}

button[type="reset"] {
    background: var(--beige-dk);
    color: var(--text);
}
</style>

<main>
    <form action="/admin/products/add" method="post" enctype="multipart/form-data">  
        <h2>Add Product</h2>
        
        <label for="product-name">Product Name</label>
        <input type="text" id="product-name" name="product-name" placeholder="Tea" required>
        
        <label for="price">Price</label>
        <div style="display: flex; align-items: center;">
            <input type="number" id="price" name="price" step="0.01" value="15" min="1" required>
            <span class="currency">EGP</span>
        </div>

        <label for="category">Category</label>
        <select name="category" id="category" required>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
            <?php endforeach; ?>
        </select>

        <label for="product-picture">Product Picture</label>
        <input type="file" id="product-picture" name="product-picture">

        <div style="margin-top: 20px;">
            <button type="submit">Save Product</button>
            <button type="reset">Reset</button>
        </div>
    </form>
</main>

<?php require base_path('views/partials/footer.php') ?>
