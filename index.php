<?php
require_once 'config/init.php';

$page_title = 'AlMe Pahiran - Nepali Traditional Clothing Ecommerce Website';
$banners = get_active_banners($conn);
$categories = get_categories($conn);
$featured_products = get_rows(
    $conn,
    "SELECT p.*, c.name AS category_name, c.slug AS category_slug,
        (SELECT image_path FROM product_images WHERE product_id = p.id ORDER BY is_main DESC, id ASC LIMIT 1) AS main_image
     FROM products p
     INNER JOIN categories c ON c.id = p.category_id
     WHERE p.is_featured = 1
     ORDER BY p.created_at DESC
     LIMIT 8"
);
$new_products = get_rows(
    $conn,
    "SELECT p.*, c.name AS category_name,
        (SELECT image_path FROM product_images WHERE product_id = p.id ORDER BY is_main DESC, id ASC LIMIT 1) AS main_image
     FROM products p
     INNER JOIN categories c ON c.id = p.category_id
     ORDER BY p.created_at DESC
     LIMIT 4"
);
$testimonials = get_testimonials($conn);

include 'includes/header.php';
?>

<section class="hero-slider">
    <?php foreach ($banners as $index => $banner): ?>
        <article class="hero-slide slide-<?php echo $index + 1; ?>" style="background-image: linear-gradient(rgba(76, 16, 36, 0.72), rgba(22, 116, 111, 0.55)), url('<?php echo h($banner['image_path']); ?>');">
            <div class="hero-content">
                <p class="eyebrow">AlMe Pahiran Collection</p>
                <h1><?php echo h($banner['title']); ?></h1>
                <p><?php echo h($banner['subtitle']); ?></p>
                <a class="button button-light" href="<?php echo h($banner['button_link']); ?>"><?php echo h($banner['button_text']); ?></a>
            </div>
        </article>
    <?php endforeach; ?>
</section>

<section class="category-strip">
    <?php foreach ($categories as $category): ?>
        <a href="products.php?category=<?php echo h($category['slug']); ?>">
            <span><?php echo h($category['name']); ?></span>
            <small><?php echo h($category['description']); ?></small>
        </a>
    <?php endforeach; ?>
</section>

<section class="content-section">
    <div class="section-heading">
        <div>
            <p class="eyebrow">Featured</p>
            <h2>Popular Picks</h2>
        </div>
        <a href="products.php">View all products</a>
    </div>

    <div class="product-grid">
        <?php foreach ($featured_products as $product): ?>
            <?php $product_sizes = sizes_text($product['available_sizes']); ?>
            <article class="product-card">
                <a href="product.php?id=<?php echo (int) $product['id']; ?>">
                    <img src="<?php echo h(product_image_or_default($product['main_image'])); ?>" alt="<?php echo h($product['title']); ?>">
                </a>
                <div class="product-card-body">
                    <p class="category-label"><?php echo h($product['category_name']); ?></p>
                    <h3><?php echo h($product['title']); ?></h3>
                    <?php if ($product_sizes !== ''): ?>
                        <p class="size-note">Sizes: <?php echo h($product_sizes); ?></p>
                    <?php endif; ?>
                    <p class="price"><?php echo format_price($product['price']); ?></p>
                    <div class="card-actions">
                        <a class="button small-button" href="product.php?id=<?php echo (int) $product['id']; ?>">View</a>
                        <form method="post" action="wishlist.php">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="product_id" value="<?php echo (int) $product['id']; ?>">
                            <input type="hidden" name="return_url" value="index.php">
                            <button type="submit" class="ghost-button small-button">
                                <?php echo is_in_wishlist($conn, $product['id']) ? 'Saved' : 'Wishlist'; ?>
                            </button>
                        </form>
                    </div>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>

<section class="split-feature">
    <div>
        <p class="eyebrow">Manual Order System</p>
        <h2>Designed for local fashion selling</h2>
        <p>
            Customers browse products, choose sizes, create an account, and send an order request.
            The seller confirms payment and delivery through social media or phone.
        </p>
        <a class="button" href="faq.php">Read FAQ</a>
    </div>
    <div class="step-grid">
        <span>1. Browse Collection</span>
        <span>2. Save Wishlist</span>
        <span>3. Login to Checkout</span>
        <span>4. Seller Confirms</span>
    </div>
</section>

<section class="content-section">
    <div class="section-heading">
        <div>
            <p class="eyebrow">New Arrivals</p>
            <h2>Recently Added</h2>
        </div>
    </div>
    <div class="product-grid compact-grid">
        <?php foreach ($new_products as $product): ?>
            <article class="product-card">
                <a href="product.php?id=<?php echo (int) $product['id']; ?>">
                    <img src="<?php echo h(product_image_or_default($product['main_image'])); ?>" alt="<?php echo h($product['title']); ?>">
                </a>
                <div class="product-card-body">
                    <p class="category-label"><?php echo h($product['category_name']); ?></p>
                    <h3><?php echo h($product['title']); ?></h3>
                    <p class="price"><?php echo format_price($product['price']); ?></p>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>

<section class="testimonial-section">
    <div class="section-heading">
        <div>
            <p class="eyebrow">Customer Words</p>
            <h2>Sample Testimonials</h2>
        </div>
    </div>
    <div class="testimonial-grid">
        <?php foreach ($testimonials as $testimonial): ?>
            <article>
                <p>"<?php echo h($testimonial['message']); ?>"</p>
                <strong><?php echo h($testimonial['customer_name']); ?></strong>
                <span><?php echo h($testimonial['location']); ?></span>
            </article>
        <?php endforeach; ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
