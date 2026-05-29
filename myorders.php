<?php
require_once 'config/init.php';

$page_title = 'My Orders - AlMe Pahiran';
$orders = get_rows($conn, 'SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC', 'i', [$_SESSION['user_id']]);

include 'includes/header.php';
?>

<section class="page-title">
    <h1>My Orders</h1>
    <p>See your previous order requests and current order status.</p>
</section>

<?php if (count($orders) > 0): ?>
    <section class="orders-list">
        <?php foreach ($orders as $order): ?>
            <?php $items = get_rows($conn, 'SELECT * FROM order_items WHERE order_id = ? ORDER BY id ASC', 'i', [$order['id']]); ?>
            <article class="order-card">
                <div class="order-card-header">
                    <div>
                        <h2>Order #<?php echo (int) $order['id']; ?></h2>
                        <p><?php echo h($order['created_at']); ?></p>
                    </div>
                    <span class="status <?php echo strtolower($order['status']); ?>"><?php echo h($order['status']); ?></span>
                </div>

                <?php foreach ($items as $item): ?>
                    <p>
                        <?php echo h($item['product_title']); ?>
                        <?php if ($item['selected_size'] !== ''): ?>
                            (<?php echo h($item['selected_size']); ?>)
                        <?php endif; ?>
                        x <?php echo (int) $item['quantity']; ?>
                        - <?php echo format_price($item['line_total']); ?>
                    </p>
                <?php endforeach; ?>

                <strong>Total: <?php echo format_price($order['total_amount']); ?></strong>
            </article>
        <?php endforeach; ?>
    </section>
<?php else: ?>
    <div class="empty-box">
        <p>You have not placed any order requests yet.</p>
        <a class="button" href="products.php">Start Shopping</a>
    </div>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>