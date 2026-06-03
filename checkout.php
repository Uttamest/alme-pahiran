<?php
require_once 'config/init.php';
require_login();

$page_title = 'Checkout - AlMe Pahiran';
$success = isset($_GET['success']);
$items = get_cart_items($conn);
$errors = [];
$user = current_user($conn);

if (!$success && count($items) === 0) {
    set_flash('error', 'Your cart is empty.');
    redirect('cart.php');
}

$full_name = $user['full_name'] ?? '';
$address = $user['address'] ?? '';
$phone = $user['phone'] ?? '';
$social_link = $user['social_link'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf()) {
        $errors[] = 'Invalid form submission.';
    }

    $items = get_cart_items($conn);

    if (count($items) === 0) {
        $errors[] = 'Your cart is empty.';
    }

    $full_name = trim($_POST['full_name'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $social_link = trim($_POST['social_link'] ?? '');

    if ($full_name === '') {
        $errors[] = 'Full name is required.';
    }

    if ($address === '') {
        $errors[] = 'Address is required.';
    }

    if (!preg_match('/^[0-9+\-\s]{7,20}$/', $phone)) {
        $errors[] = 'Please enter a valid phone number.';
    }

    if ($social_link === '') {
        $errors[] = 'Please enter a social media/contact link.';
    }

    if (count($errors) === 0) {
        $total = cart_total($items);
        $cart_id = find_cart_id($conn);

        try {
            mysqli_begin_transaction($conn);

            run_query(
                $conn,
                'UPDATE users SET full_name = ?, address = ?, phone = ?, social_link = ? WHERE id = ?',
                'ssssi',
                [$full_name, $address, $phone, $social_link, $_SESSION['user_id']]
            );

            run_query(
                $conn,
                'INSERT INTO orders (user_id, full_name, address, phone, social_link, total_amount, status)
                 VALUES (?, ?, ?, ?, ?, ?, "Pending")',
                'issssd',
                [$_SESSION['user_id'], $full_name, $address, $phone, $social_link, $total]
            );

            $order_id = mysqli_insert_id($conn);

            foreach ($items as $item) {
                $price = (float) $item['price'];
                $quantity = (int) $item['quantity'];
                $line_total = $price * $quantity;

                run_query(
                    $conn,
                    'INSERT INTO order_items (order_id, product_id, product_title, selected_size, price, quantity, line_total)
                     VALUES (?, ?, ?, ?, ?, ?, ?)',
                    'iissdid',
                    [$order_id, $item['product_id'], $item['title'], $item['selected_size'], $price, $quantity, $line_total]
                );
            }

            if ($cart_id) {
                run_query($conn, 'DELETE FROM cart_items WHERE cart_id = ?', 'i', [$cart_id]);
            }

            mysqli_commit($conn);

            $_SESSION['last_order_id'] = $order_id;
            redirect('checkout.php?success=1');
        } catch (Exception $e) {
            mysqli_rollback($conn);
            $errors[] = 'Order could not be submitted. Please try again.';
        }
    }
}

include 'includes/header.php';
?>

<?php if ($success): ?>
    <section class="success-panel">
        <h1>Order Request Sent</h1>
        <p>Your order request has been received. The seller will contact you for manual payment and confirmation.</p>
        <?php if (!empty($_SESSION['last_order_id'])): ?>
            <p class="order-number">Order number: #<?php echo (int) $_SESSION['last_order_id']; ?></p>
        <?php endif; ?>
        <a class="button" href="myorders.php">View My Orders</a>
    </section>
<?php else: ?>
    <section class="page-title">
        <h1>Checkout</h1>
        <p>Your saved profile details are filled automatically. You can edit them for this order.</p>
    </section>

    <?php if (count($errors) > 0): ?>
        <div class="message error">
            <?php foreach ($errors as $error): ?>
                <p><?php echo h($error); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <section class="checkout-layout">
        <form method="post" class="form-box">
            <?php echo csrf_field(); ?>

            <label for="full_name">Full Name</label>
            <input type="text" id="full_name" name="full_name" value="<?php echo h($full_name); ?>" required>

            <label for="address">Address</label>
            <textarea id="address" name="address" rows="4" required><?php echo h($address); ?></textarea>

            <label for="phone">Phone Number</label>
            <input type="text" id="phone" name="phone" value="<?php echo h($phone); ?>" required>

            <label for="social_link">Social Media / Contact Link</label>
            <input type="text" id="social_link" name="social_link" value="<?php echo h($social_link); ?>" required>

            <button type="submit">Submit Order Request</button>
        </form>

        <aside class="cart-summary">
            <h2>Order Summary</h2>
            <?php foreach ($items as $item): ?>
                <p>
                    <?php echo h($item['title']); ?>
                    <?php if ($item['selected_size'] !== ''): ?>
                        (<?php echo h($item['selected_size']); ?>)
                    <?php endif; ?>
                    x <?php echo (int) $item['quantity']; ?>
                </p>
            <?php endforeach; ?>
            <p class="detail-price"><?php echo format_price(cart_total($items)); ?></p>
            <p class="small-text">Payment is handled manually after seller confirmation.</p>
        </aside>
    </section>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
