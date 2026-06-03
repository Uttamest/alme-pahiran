    </main>

    <footer class="site-footer">
        <div class="footer-inner">
            <div>
                <h2>AlMe Pahiran</h2>
                <p>Traditional Nepali clothing, kurtha, sari, dhaka-inspired pieces, and accessories.</p>
                <p class="small-text">A university student group project using PHP, HTML, CSS, and MySQL.</p>
            </div>

            <div>
                <h3>Quick Links</h3>
                <a href="products.php">Products</a>
                <a href="about.php">About Us</a>
                <a href="contact.php">Contact</a>
                <a href="faq.php">FAQ</a>
                <a href="admin/login.php">Admin</a>
            </div>

            <div>
                <h3>Follow AlMe Pahiran</h3>
                <div class="social-row">
                    <?php foreach (social_links() as $name => $url): ?>
                        <a href="<?php echo h($url); ?>" target="_blank" rel="noopener"><?php echo h($name); ?></a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <p class="footer-copy">
            &copy; <?php echo date('Y'); ?> AlMe Pahiran. Team: SHRESTHA UTTAM, THAPA MANISHA, SHRESTHA PRAGESH, KHAND THAKURI SHRADDHA.
        </p>
    </footer>
</body>
</html>
