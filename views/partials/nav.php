<nav class="main-nav">
    <div class="container">
        <div class="nav-wrapper">
            <div class="logo">
                <a href="/">
                    <span class="logo-text">CAFETERIA</span>
                </a>
            </div>
            <ul class="nav-links">
                <li><a href="/" class="<?= urlIs('/') ? 'active' : '' ?>">Home</a></li>
                <li><a href="/user/my_orders" class="<?= urlIs('/user/my_orders') ? 'active' : '' ?>">My order</a></li>
                <?php if (isset($_SESSION['user']) && $_SESSION['user']['is_admin']) : ?>
                    <li><a href="/admin/products" class="<?= urlIs('/admin/products') ? 'active' : '' ?>">Products</a></li>
                    <li><a href="/admin/users" class="<?= urlIs('/admin/users') ? 'active' : '' ?>">users</a></li>
                    <li><a href="/admin/manual_order" class="<?= urlIs('/admin/manual_order') ? 'active' : '' ?>"order</a></li>
                    <li><a href="/admin/checks" class="<?= urlIs('/admin/checks') ? 'active' : '' ?>">reports</a></li>
                <?php endif; ?>
            </ul>
            <div class="user-actions">
                <?php if (isset($_SESSION['user'])) : ?>
                    <span class="user-name"><?= $_SESSION['user']['name'] ?></span>
                    <form action="/logout" method="POST" style="display: inline;">
                        <button type="submit" class="logout-btn">logout </button>
                    </form>
                <?php else : ?>
                    <a href="/login" class="login-btn">login </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>
