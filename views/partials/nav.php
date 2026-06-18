<nav class="nav">
    <div class="container nav-container">
        <div class="logo">
            <a href="/">
                <img src="/images/logo.png" alt="Cafeteria Logo">
            </a>
        </div>

        <div class="pages">
            <ul>
                <?php if(isset($_SESSION['user'])): ?>
                    <?php if($_SESSION['user']['role'] === 'admin'): ?>
                        <li><a href="/admin/orders" class="<?= urlIs('/admin/orders') ? 'active' : '' ?>">Orders</a></li>
                        <li><a href="/admin/products" class="<?= urlIs('/admin/products') ? 'active' : '' ?>">Products</a></li>
                        <li><a href="/admin/users" class="<?= urlIs('/admin/users') ? 'active' : '' ?>">Users</a></li>
                        <li><a href="/admin/manual_order" class="<?= urlIs('/admin/manual_order') ? 'active' : '' ?>">Manual Order</a></li>
                        <li><a href="/admin/checks" class="<?= urlIs('/admin/checks') ? 'active' : '' ?>">Checks</a></li>
                    <?php else: ?>
                        <li><a href="/user/home" class="<?= urlIs('/user/home') ? 'active' : '' ?>">Home</a></li>
                        <li><a href="/user/my_orders" class="<?= urlIs('/user/my_orders') ? 'active' : '' ?>">My Orders</a></li>
                        <li><a href="/user/products" class="<?= urlIs('/user/products') ? 'active' : '' ?>">Products</a></li>
                    <?php endif; ?>

                    <style>
                        .logout-btn {
                            background-color: #343a40;
                            color: white;
                            border: 1px solid #343a40;
                            padding: 8px 20px;
                            border-radius: 6px;
                            cursor: pointer;
                            font-weight: 500;
                            transition: all 0.3s ease;
                            margin-left: 10px;
                        }

                        .logout-btn:hover {
                             background-color: transparent;
                             color: #343a40;
                            box-shadow: 0 2px 5px rgba(0,0,0,0.1);                            transform: translateY(-1px);
                        }
                    </style>

                    <li>
                        <form action="/logout" method="POST" style="display: inline;">
                            <button type="submit" class="logout-btn">Logout</button>
                        </form>
                    </li>
                <?php else: ?>
                    <li><a href="/" class="<?= urlIs('/') ? 'active' : '' ?>">Login</a></li>
                    <li><a href="/login" class="<?= urlIs('/login') ? 'active' : '' ?>">Login</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
