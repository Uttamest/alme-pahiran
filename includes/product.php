<?php
require_once 'config/init.php';

$product_id = (int) ($_GET['id'] ?? 0);

if ($product_id < 1) {
    set_flash('error', 'Product not found.');
    redirect('products.php');
}

$product = get_one(
    $conn,
    'SELECT p.*, c.name AS category_name, c.slug AS category_slug
     FROM products p
     INNER JOIN categories c ON c.id = p.category_id
     WHERE p.id = ?
     LIMIT 1',
    'i',
    [$product_id]
);

if (!$product) {
    set_flash('error', 'Product not found.');
    redirect('products.php');
}

$available_sizes = parse_sizes($product['available_sizes']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf()) {
        set_flash('error', 'Invalid form submission.');
        redirect('product.php?id=' . $product_id);
    }

    $quantity = (int) ($_POST['quantity'] ?? 1);
    $selected_size = trim($_POST['selected_size'] ?? '');

    if ($quantity < 1) {
        $quantity = 1;
    }

    if ($quantity > 20) {
        $quantity = 20;
    }

    if (count($available_sizes) > 0 && !in_array($selected_size, $available_sizes)) {
        set_flash('error', 'Please choose an available size.');
        redirect('product.php?id=' . $product_id);
    }

    $cart_id = get_cart_id($conn);
    run_query(
        $conn,
        'INSERT INTO cart_items (cart_id, product_id, quantity, selected_size)
         VALUES (?, ?, ?, ?)
         ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(quantity)',
        'iiis',
        [$cart_id, $product_id, $quantity, $selected_size]
    );

    set_flash('success', 'Product added to cart.');
    redirect('product.php?id=' . $product_id);
}

$images = get_rows($conn, 'SELECT * FROM product_images WHERE product_id = ? ORDER BY is_main DESC, id ASC', 'i', [$product_id]);
$related_products = get_rows(
    $conn,
    "SELECT p.*, c.name AS category_name,
        (SELECT image_path FROM product_images WHERE product_id = p.id ORDER BY is_main DESC, id ASC LIMIT 1) AS main_image
     FROM products p
     INNER JOIN categories c ON c.id = p.category_id
     WHERE p.category_id = ? AND p.id <> ?
     ORDER BY p.created_at DESC
     LIMIT 4",
    'ii',
    [$product['category_id'], $product_id]
);
$page_title = $product['title'] . ' - AlMe Pahiran';

include 'includes/header.php';
?>

<section class="product-detail">
    <div class="product-gallery">
        <?php if (count($images) > 0): ?>
            <?php foreach ($images as $image): ?>
                <img src="<?php echo h($image['image_path']); ?>" alt="<?php echo h($product['title']); ?>">
            <?php endforeach; ?>
        <?php else: ?>
            <img src="<?php echo h(product_image_or_default('')); ?>" alt="<?php echo h($product['title']); ?>">
        <?php endif; ?>
    </div>

    <div class="product-info">
        <p class="category-label"><?php echo h($product['category_name']); ?></p>
        <h1><?php echo h($product['title']); ?></h1>
        <p class="detail-price"><?php echo format_price($product['price']); ?></p>

        <div class="product-meta-grid">
            <div>
                <span>Stock</span>
                <strong><?php echo h($product['stock_status']); ?></strong>
            </div>
            <div>
                <span>Order</span>
                <strong>Manual payment</strong>
            </div>
            <div>
                <span>Category</span>
                <strong><?php echo h($product['category_name']); ?></strong>
            </div>
        </div>

        <div class="detail-block">
            <h2>Product Details</h2>
            <p><?php echo nl2br(h($product['description'])); ?></p>
        </div>

        <?php if (count($available_sizes) > 0): ?>
            <div class="detail-block">
                <h2>Available Sizes</h2>
                <div class="size-list">
                    <?php foreach ($available_sizes as $size): ?>
                        <span><?php echo h($size); ?></span>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <form method="post" class="cart-form">
            <?php echo csrf_field(); ?>

            <?php if (count($available_sizes) > 0): ?>
                <fieldset class="size-picker">
                    <legend>Choose Size</legend>
                    <?php foreach ($available_sizes as $index => $size): ?>
                        <label>
                            <input type="radio" name="selected_size" value="<?php echo h($size); ?>" <?php echo $index === 0 ? 'checked' : ''; ?>>
                            <span><?php echo h($size); ?></span>
                        </label>
                    <?php endforeach; ?>
                </fieldset>
            <?php endif; ?>

            <div class="quantity-row">
                <label for="quantity">Quantity</label>
                <input type="number" id="quantity" name="quantity" value="1" min="1" max="20">
            </div>

            <button type="submit">Add to Cart</button>
        </form>

        <form method="post" action="wishlist.php" class="wishlist-detail-form">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="product_id" value="<?php echo (int) $product['id']; ?>">
            <input type="hidden" name="return_url" value="product.php?id=<?php echo (int) $product['id']; ?>">
            <button type="submit" class="ghost-button full-button">
                <?php echo is_in_wishlist($conn, $product['id']) ? 'Remove from Wishlist' : 'Add to Wishlist'; ?>
            </button>
        </form>

        <div class="seller-note">
            <h2>Need fitting help?</h2>
            <p>Message the seller with product name, size, and delivery location.</p>
            <div class="social-row">
                <?php foreach (social_links() as $name => $url): ?>
                    <a href="<?php echo h($url); ?>" target="_blank" rel="noopener"><?php echo h($name); ?></a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<?php if (count($related_products) > 0): ?>
    <section class="content-section related-products">
        <div class="section-heading">
            <h2>Related Products</h2>
            <a href="products.php?category=<?php echo h($product['category_slug']); ?>">More in <?php echo h($product['category_name']); ?></a>
        </div>
        <div class="product-grid compact-grid">
            <?php foreach ($related_products as $related): ?>
                <article class="product-card">
                    <a href="product.php?id=<?php echo (int) $related['id']; ?>">
                        <img src="<?php echo h(product_image_or_default($related['main_image'])); ?>" alt="<?php echo h($related['title']); ?>">
                    </a>
                    <div class="product-card-body">
                        <p class="category-label"><?php echo h($related['category_name']); ?></p>
                        <h3><?php echo h($related['title']); ?></h3>
                        <p class="price"><?php echo format_price($related['price']); ?></p>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </section>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
