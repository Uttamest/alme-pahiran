<?php
require_once 'config/init.php';

$page_title = 'FAQ - AlMe Pahiran';
include 'includes/header.php';
?>

<section class="page-title">
    <h1>Frequently Asked Questions</h1>
    <p>Simple answers about ordering from AlMe Pahiran.</p>
</section>

<section class="faq-list">
    <article>
        <h2>Do I need an account to order?</h2>
        <p>Yes. You can browse products without login, but checkout requires a customer account.</p>
    </article>
    <article>
        <h2>Is online payment available?</h2>
        <p>No. This project uses an order request system only. The seller contacts the customer manually for payment.</p>
    </article>
    <article>
        <h2>Can I save my address?</h2>
        <p>Yes. Login and update your profile. The saved details are automatically filled during checkout.</p>
    </article>
    <article>
        <h2>Are product sizes dynamic?</h2>
        <p>Yes. Admin can enter available sizes such as S, M, L, XL, Free Size, or fabric measurements.</p>
    </article>
    <article>
        <h2>Can admin change homepage banners?</h2>
        <p>Yes. Admin can manage banner title, image, button, active status, and display order.</p>
    </article>
</section>

<?php include 'includes/footer.php'; ?>
