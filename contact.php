<?php
require_once 'config/init.php';

$page_title = 'Contact - AlMe Pahiran';
include 'includes/header.php';
?>

<section class="page-title">
    <h1>Contact</h1>
    <p>Contact the seller for product videos, size confirmation, payment, and delivery discussion.</p>
</section>

<section class="contact-layout">
    <div class="form-box">
        <h2>Social Media</h2>
        <p>AlMe Pahiran currently handles customer communication through social media.</p>
        <div class="social-row">
            <?php foreach (social_links() as $name => $url): ?>
                <a href="<?php echo h($url); ?>" target="_blank" rel="noopener"><?php echo h($name); ?></a>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="form-box">
        <h2>Store Help</h2>
        <p><strong>Order:</strong> Add products to cart and checkout after login.</p>
        <p><strong>Payment:</strong> The seller contacts the customer manually.</p>
        <p><strong>Delivery:</strong> Delivery details are confirmed after order request.</p>
        <p><strong>Project:</strong> University student group ecommerce website.</p>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
