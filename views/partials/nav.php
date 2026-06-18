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
                            background: none;
                            border: none;
                            color: var(--text-mid, #6B5B3E);
                            font-weight: 600;
                            cursor: pointer;
                            padding: 0;
                            font-size: 16px;
                            font-family: inherit;
                            transition: all 0.3s ease;
                        }

                        .logout-btn:hover {
                            color: #E05252;
                            text-decoration: underline;
                            transform: scale(1.05);
                        }

                        .nav-links li form {
                            display: inline;
                            margin: 0;
                            padding: 0;
                        }

                    </style>
                    <li>
                        <form action="/logout" method="POST" style="display: inline;">
                            <button type="submit" class="logout-btn">Logout</button>
                        </form>
                    </li>
                <?php else: ?>
                    <li><a href="/login" class="<?= urlIs('/login') || urlIs('/') ? 'active' : '' ?>">Login</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
