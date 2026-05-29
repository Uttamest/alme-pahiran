<?php
$nav_categories = get_categories($conn);
?>
<header class="site-header">
    <div class="top-bar">
        <p>AlMe Pahiran - Nepali Traditional Clothing Ecommerce Website</p>
        <div class="top-social">
            <?php foreach (social_links() as $name => $url): ?>
                <a href="<?php echo h($url); ?>" target="_blank" rel="noopener"><?php echo h($name); ?></a>
            <?php endforeach; ?>
        </div>
    </div>

    <nav class="navbar">
        <a class="brand" href="index.php">
            <span>AlMe</span>
            <small>Pahiran</small>
        </a>

        <form class="nav-search" action="products.php" method="get">
            <input type="text" name="search" placeholder="Search sari, kurtha, jewelry..." value="<?php echo h($_GET['search'] ?? ''); ?>">
            <button type="submit">Search</button>
        </form>

        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="products.php">Products</a>
            <a href="about.php">About</a>
            <a href="contact.php">Contact</a>
            <a href="cart.php">Cart (<?php echo get_cart_count($conn); ?>)</a>
            <a href="wishlist.php">Wishlist (<?php echo wishlist_count($conn); ?>)</a>
            <?php if ($logged_user): ?>
                <a href="profile.php"><?php echo h(explode(' ', $logged_user['full_name'])[0]); ?></a>
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="login.php">Login</a>
            <?php endif; ?>
        </div>
    </nav>

    <div class="category-nav">
        <?php foreach ($nav_categories as $category): ?>
            <a href="products.php?category=<?php echo h($category['slug']); ?>"><?php echo h($category['name']); ?></a>
        <?php endforeach; ?>
    </div>
</header>
