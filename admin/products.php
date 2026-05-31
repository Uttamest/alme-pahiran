<?php
require_once '../config/init.php';
require_admin();

$page_title = 'Manage Products - AlMe Pahiran';
$products = get_rows(
    $conn,
    "SELECT p.*, c.name AS category_name,
        (SELECT image_path FROM product_images WHERE product_id = p.id ORDER BY is_main DESC, id ASC LIMIT 1) AS main_image
     FROM products p
     INNER JOIN categories c ON c.id = p.category_id
     ORDER BY p.created_at DESC"
);

include 'includes/admin_header.php';
?>

<section class="page-title with-action">
    <div>
        <h1>Products</h1>
        <p>Add, edit, or delete products. Images and categories are dynamic.</p>
    </div>
    <a class="button" href="add_product.php">Add Product</a>
</section>

<?php if (count($products) > 0): ?>
    <section class="admin-product-list">
        <?php foreach ($products as $product): ?>
            <article class="admin-product-row">
                <img src="../<?php echo h(product_image_or_default($product['main_image'])); ?>" alt="<?php echo h($product['title']); ?>">
                <div>
                    <p class="category-label"><?php echo h($product['category_name']); ?></p>
                    <h3><?php echo h($product['title']); ?></h3>
                    <p><?php echo format_price($product['price']); ?> | <?php echo h($product['stock_status']); ?></p>
                    <?php if (sizes_text($product['available_sizes']) !== ''): ?>
                        <p class="size-note">Sizes: <?php echo h(sizes_text($product['available_sizes'])); ?></p>
                    <?php endif; ?>
                </div>
                <div class="admin-row-actions">
                    <a class="button small-button" href="../product.php?id=<?php echo (int) $product['id']; ?>" target="_blank">View</a>
                    <a class="button small-button" href="edit_product.php?id=<?php echo (int) $product['id']; ?>">Edit</a>
                    <form method="post" action="delete_product.php">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="product_id" value="<?php echo (int) $product['id']; ?>">
                        <button type="submit" class="danger-button small-button">Delete</button>
                    </form>
                </div>
            </article>
        <?php endforeach; ?>
    </section>
<?php else: ?>
    <div class="empty-box">
        <p>No products yet.</p>
        <a class="button" href="add_product.php">Add Product</a>
    </div>
<?php endif; ?>

<?php include 'includes/admin_footer.php'; ?>
