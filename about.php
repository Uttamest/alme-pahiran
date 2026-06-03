<?php
require_once 'config/init.php';

$page_title = 'About Us - AlMe Pahiran';
include 'includes/header.php';
?>

<section class="page-title">
    <h1>About AlMe Pahiran</h1>
    <p>A student-built Nepali traditional clothing ecommerce website.</p>
</section>

<section class="split-feature">
    <div>
        <p class="eyebrow">Project Introduction</p>
        <h2>Fashion ecommerce for traditional Nepali style</h2>
        <p>
            AlMe Pahiran is designed for sari, kurtha, Nepali traditional clothes,
            dhaka-inspired items, and accessories. Customers can browse, save wishlist
            items, create an account, and send manual order requests.
        </p>
        <p>
            The website uses PHP sessions, mysqli prepared statements, MySQL tables,
            and reusable PHP includes. It is modern enough for presentation but still
            readable for university students learning web development.
        </p>
    </div>
    <div class="team-card">
        <h2>Team Members</h2>
        <p><strong>SHRESTHA UTTAM</strong> - Team Leader</p>
        <p><strong>THAPA MANISHA</strong></p>
        <p><strong>SHRESTHA PRAGESH</strong></p>
        <p><strong>KHAND THAKURI SHRADDHA</strong></p>
    </div>
</section>

<section class="testimonial-section">
    <div class="section-heading">
        <h2>Project Goals</h2>
    </div>
    <div class="testimonial-grid">
        <article>
            <strong>Dynamic Store</strong>
            <p>Products, categories, banners, users, orders, and wishlist are connected to MySQL.</p>
        </article>
        <article>
            <strong>Manual Payment</strong>
            <p>No online gateway is used. Sellers contact customers through phone or social media.</p>
        </article>
        <article>
            <strong>Student Friendly</strong>
            <p>The code avoids frameworks and keeps pages easy to edit for coursework.</p>
        </article>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
