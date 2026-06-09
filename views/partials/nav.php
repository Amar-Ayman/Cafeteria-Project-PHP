<nav class="nav">
    <div class="container nav-container">
        <div class="logo">
            <a href="/">
                <img src="/images/logo.png" alt="Cafeteria Logo">
            </a>
        </div>

        <div class="pages">
            <ul>
                <li><a href="/" class="<?= urlIs('/') ? 'active' : '' ?>">Home</a></li>
                <li><a href="/user/home" class="<?= urlIs('/user/home') ? 'active' : '' ?>">Products</a></li>

                <?php if(isset($_SESSION['user'])): ?>
                    <li><a href="/user/cart" class="<?= urlIs('/user/cart') ? 'active' : '' ?>">Cart</a></li>
                    <li><a href="/user/my_orders" class="<?= urlIs('/user/my_orders') ? 'active' : '' ?>">My Orders</a></li>

                    <?php if($_SESSION['user']['role'] === 'admin'): ?>
                        <li><a href="/admin/checks" class="<?= urlIs('/admin/checks') ? 'active' : '' ?>">Dashboard</a></li>
                        <li><a href="/admin/products" class="<?= urlIs('/admin/products') ? 'active' : '' ?>">Manage Products</a></li>
                        <li><a href="/admin/users" class="<?= urlIs('/admin/users') ? 'active' : '' ?>">Add User</a></li>
                        <li><a href="/admin/orders" class="<?= urlIs('/admin/orders') ? 'active' : '' ?>">Orders</a></li>
                    <?php endif; ?>

                    <li>
                        <form action="/logout" method="POST" style="display: inline;">
                            <button type="submit" class="logout-btn">Logout</button>
                        </form>
                    </li>
                <?php else: ?>
                    <li><a href="/login" class="<?= urlIs('/login') ? 'active' : '' ?>">Login</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
