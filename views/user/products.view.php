<?php 
/** @var array $products */
/** @var array $categories */

require base_path("views/partials/head.php");
require base_path("views/partials/nav.php");
?>
<style>
   :root {
      --gold:         #B8973A;              
      --gold-lt:      #D4AF55;              
      --gold-dk:      #EDD98A;              
      --bg:           #FDFAF4;              
      --surface:      #F5EFE0;              
      --card:         #FFFFFF;              
      --border:       rgba(184,151,58,.25);  
      --border-lt:    rgba(184,151,58,.12);  
      --text:         #2C2418;              
      --muted:        #6B5B3E;              
      --green:        #4CAF8A;              
      --dark:         #1E1A12;              
      --white:        #FFFFFF;              
   }

   .products-container {
      max-width: 1200px;
      margin: 40px auto;
      padding: 0 20px;
      direction: ltr;
   }

   .products-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
      flex-wrap: wrap;
      gap: 20px;
   }
   .products-header h1 span {
      color: #B8973A;
   }

   .products-title {
      color: var(--dark);
      font-size: 35px;
      text-transform: uppercase;
      position: relative;
      margin: 0;
   }

   .products-title::after {
      content: '';
      display: block;
      width: 60px;
      height: 3px;
      background: var(--gold);
      margin-top: 5px;
      border-radius: 2px;
   }

   .btn-cart {
      background: var(--gold);
      color: var(--white);
      text-decoration: none;
      padding: 12px 25px;
      border-radius: 30px;
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: 10px;
      transition: 0.3s;
      box-shadow: 0 4px 15px rgba(184, 151, 58, 0.2);
   }

   .btn-cart:hover {
      background: #654321  ;
      /* transform: translateY(-2px); */
      scale: 1.1;
   }

   .cart-count {
      background: var(--white);
      color: var(--gold);
      padding: 2px 8px;
      border-radius: 50%;
      font-size: 14px;
   }

   .category-filter {
      display: flex;
      justify-content: center;
      gap: 10px;
      margin-bottom: 40px;
      flex-wrap: wrap;
   }

   .filter-link {
      text-decoration: none;
      color: var(--muted);
      padding: 8px 18px;
      border: 1px solid var(--gold-pale);
      border-radius: 20px;
      font-size: 14px;
      font-weight: 500;
      transition: 0.3s;
      background: var(--white);
   }

   .filter-link:hover, .filter-link.active {
      background: var(--gold);
      color: var(--white);
      border-color: var(--gold);
   }

   .products-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      gap: 30px;
   }

   .product-card {
      background: #F6EBDD;
      border: 1px solid #D4AF55;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 4px 15px rgba(0,0,0,0.03);
      transition: 0.3s;
      display: flex;
      flex-direction: column;
   }

   .product-card:hover {
      box-shadow: 0 0 10px #D4AF55;
      transform: translateY(-10px);
   }

   .product-image-wrapper {
      width: 100%;
      height: 200px;
      background-color: var(--bg);
      overflow: hidden;
   }

   .product-card img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: 0.5s;
   }

   .product-info {
      padding: 20px;
      text-align: center;
   }

   .product-name {
      font-size: 18px;
      color: var(--text);
      margin: 0 0 8px 0;
      font-weight: bold;
   }

   .product-price {
      font-size: 20px;
      color: var(--gold);
      font-weight: 700;
      margin-bottom: 15px;
   }

   .btn-add-order {
      width: 90%;
      background: #fff;
      color: var(--gold);
      border: 1px solid var(--gold-pale);
      padding: 10px;
      border-radius: 20px;
      cursor: pointer;
      font-weight: 600;
      font-family: 'Jost', sans-serif;
      transition: 0.3s;
   }

   .btn-add-order:hover {
      background: var(--gold);
      color: var(--white);
      border-color: var(--gold);
   }

   .no-products {
      text-align: center;
      padding: 50px;
      color: var(--muted);
      grid-column: 1 / -1;
   }
</style>

<main class="products-container">
   <div class="products-header">
      <h1 class="products-title">Our <span class="header">Menu</span></h1>
      <a href="/order" class="btn-cart">
         <span>View cart</span>
         <span class="cart-count" id="cart-count">0</span>
      </a>
   </div>

   <!-- Category Filter -->
   <div class="category-filter">
      <a href="/user/products" class="filter-link <?= !isset($_GET['category']) ? 'active' : '' ?>">All Items</a>
      <?php foreach ($categories as $category) : ?>
         <a href="/user/products?category=<?= $category['id'] ?>" 
            class="filter-link <?= (isset($_GET['category']) && $_GET['category'] == $category['id']) ? 'active' : '' ?>">
            <?= htmlspecialchars($category['name']) ?>
         </a>
      <?php endforeach; ?>
   </div>

   <div class="products-grid">
      <?php if (empty($products)) : ?>
         <div class="no-products">
            <h3>No products found in this category.</h3>
         </div>
      <?php else : ?>
         <?php foreach($products as $product) : ?>
            <div class="product-card">
               <div class="product-image-wrapper">
                  <img src="/images/<?= $product['image'] ?: 'default-coffee.png' ?>"
                       alt="<?= htmlspecialchars($product['name']) ?>">
               </div>
               
               <div class="product-info">
                  <h3 class="product-name"><?= htmlspecialchars($product['name']) ?></h3>
                  <div class="product-price"><?= number_format($product['price'], 2) ?> EGP</div>
                  
                  <button class="btn-add-order" 
                          onclick="addToOrder(<?= $product['id'] ?>, '<?= htmlspecialchars($product['name']) ?>', <?= $product['price'] ?>)">
                     Add to Order
                  </button>
               </div>
            </div>
         <?php endforeach; ?>
      <?php endif; ?>
   </div>
</main>

<script>
    // Initialize or get cart from localStorage
    function getCart() {
        return JSON.parse(localStorage.getItem('cafe_order')) || [];
    }

    function saveCart(cart) {
        localStorage.setItem('cafe_order', JSON.stringify(cart));
        updateCartCount();
    }

    function updateCartCount() {
        const cart = getCart();
        const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
        document.getElementById('cart-count').innerText = totalItems;
    }

    function addToOrder(id, name, price) {
        let cart = getCart();
        
        // Check if item already in cart
        const existingItem = cart.find(item => item.id === id);
        
        if (existingItem) {
            existingItem.quantity += 1;
        } else {
            cart.push({
                id: id,
                name: name,
                price: price,
                quantity: 1
            });
        }
        
        saveCart(cart);
        
        // Optional: Alert or feedback
        const btn = event.target;
        const originalText = btn.innerText;
        btn.innerText = "✓ Added";
        btn.style.background = "var(--green)";
        btn.style.color = "white";
        
        setTimeout(() => {
            btn.innerText = originalText;
            btn.style.background = "";
            btn.style.color = "";
        }, 1000);
    }

    // Run on page load
    document.addEventListener('DOMContentLoaded', updateCartCount);
</script>

<?php require base_path("views/partials/footer.php"); ?>