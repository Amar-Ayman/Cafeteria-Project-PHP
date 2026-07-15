<?php 
/** @var array $products */
/** @var array $categories */

require base_path("views/partials/head.php");
require base_path("views/partials/nav.php");
?>
<style>
   :root {
      --gold: #B8973A;              
      --gold-light: #D4AF55;              
      --gold-pale: #EDD98A;              
      --gold-faint: #F7F0DC;              
      --bg: #FDFAF4;              
      --surface: #F5EFE0;              
      --card: #FFFFFF;              
      --border: rgba(184,151,58,.2);  
      --text: #2C2418;              
      --muted: #6B5B3E;              
      --dark: #1E1A12;              
      --white: #FFFFFF;
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
      font-family: 'Cormorant Garamond', serif;
      font-weight: 700;
      letter-spacing: 3px;
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
      background: var(--dark);
      color: var(--gold-pale);
      text-decoration: none;
      padding: 12px 25px;
      border-radius: 30px;
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: 10px;
      transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
      box-shadow: 0 4px 15px rgba(184, 151, 58, 0.2);
   }

   .btn-cart:hover {
       background: var(--gold);
      color: var(--white);
      border-color: var(--gold);
      transform: translateY(-3px);
      box-shadow: 0 15px 30px rgba(184, 151, 58, 0.3);
   }

   .cart-count {
      background: var(--white);
      color: var(--gold);
      padding: 2px 8px;
      border-radius: 50%;
      font-size: 14px;
   }

   /* Category Filter */
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
      transition: all 0.4s ease;
      background: var(--white);
      cursor: pointer;
      text-transform: uppercase;
      letter-spacing: 2px;
   }

   .filter-link:hover, .filter-link.active {
      background: var(--dark);
      color: var(--gold-pale);
      border-color: var(--dark);
      transform: translateY(-2px);
   }

   .products-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      gap: 30px;
   }

   .product-card {
      background: var(--card);
      border: 1px solid var(--gold-faint);
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 4px 15px rgba(0,0,0,0.03);
      transition: all 0.5s cubic-bezier(0.165, 0.84, 0.44, 1);
      display: flex;
      flex-direction: column;
      position: relative;
   }

   .product-card:hover {
      transform: translateY(-15px);
      box-shadow: 0 30px 60px rgba(184, 151, 58, 0.15);
      border-color: var(--gold-pale);
   }

   .product-image-wrapper {
      width: 100%;
      height: 200px;
      background-color: var(--bg);
      overflow: hidden;
      position: relative;
   }

   .product-card img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.8s cubic-bezier(0.165, 0.84, 0.44, 1);
   }

   .product-card:hover img {
      transform: scale(1.15);
   }

   /* Subtle Overlay on Hover */
   .product-image-wrapper::after {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(to bottom, transparent 0%, rgba(44, 36, 24, 0.2) 100%);
      opacity: 0;
      transition: opacity 0.4s ease;
   }

   .product-card:hover .product-image-wrapper::after {
      opacity: 1;
   }

   .product-info {
      padding: 20px;
      text-align: center;
      flex-grow: 1;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      background: var(--white);
   }

   .product-name {
      font-size: 18px;
      color: var(--text-dark);
      margin: 0 0 8px 0;
      font-weight: bold;
      font-family: 'Cormorant Garamond', serif;
      letter-spacing: 1px;
   }

   .product-price {
      font-size: 20px;
      color: var(--gold);
      font-weight: 700;
      margin-bottom: 15px;
      font-family: 'Jost', sans-serif;
      letter-spacing: 1px;
   }

   .btn-add-order {
      width: 100%;
      background: transparent;
      color: var(--gold);
      border: 1px solid var(--gold);
      padding: 10px;
      border-radius: 20px;
      cursor: pointer;
      font-weight: 600;
      font-family: 'Jost', sans-serif;
      transition: all 0.4s ease;
      font-size: 0.85rem;
      text-transform: uppercase;
      letter-spacing: 2px;
      position: relative;
      overflow: hidden;
      z-index: 1;
   }

   .btn-add-order::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: var(--gold);
      transition: all 0.4s ease;
      z-index: -1;
   }


   .btn-add-order:hover {
      color: var(--white);
   }
   
   .btn-add-order:hover::before {
      left: 0;
   }

   .btn-add-order.added {
      background: var(--dark);
      border-color: var(--dark);
      color: var(--gold-pale);
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