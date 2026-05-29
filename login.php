<?php
require_once 'config/init.php';

if (is_logged_in()) {
    redirect('profile.php');
}

$page_title = 'Login - AlMe Pahiran';
$errors = [];
$email = '';
$next = safe_return_url($_GET['next'] ?? 'profile.php', 'profile.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf()) {
        $errors[] = 'Invalid form submission.';
    }

    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $next = safe_return_url($_POST['next'] ?? 'profile.php', 'profile.php');

    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') {
        $errors[] = 'Email and password are required.';
    }

    if (count($errors) === 0) {
        $user = get_one($conn, 'SELECT * FROM users WHERE email = ? LIMIT 1', 's', [$email]);

        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];

            if (!empty($_SESSION['cart_token'])) {
                $cart_id = find_cart_id($conn);

                if ($cart_id) {
                    run_query($conn, 'UPDATE cart SET user_id = ? WHERE id = ?', 'ii', [$user['id'], $cart_id]);
                }
            }

            redirect($next);
        }

        $errors[] = 'Invalid email or password.';
    }
}

include 'includes/header.php';
?>

<section class="auth-layout">
    <div class="auth-info">
        <p class="eyebrow">Welcome Back</p>
        <h1>Login to order</h1>
        <p>Customers can browse freely, but must login before checkout so order history and saved details work properly.</p>
    </div>

    <form method="post" class="form-box auth-form">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="next" value="<?php echo h($next); ?>">
        <h2>Customer Login</h2>

        <?php if (count($errors) > 0): ?>
            <div class="message error">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo h($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?php echo h($email); ?>" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Login</button>
        <p class="small-text">No account yet? <a href="signup.php">Create one</a>.</p>
        <p class="small-text">Sample customer: customer@example.com / user123</p>
    </form>
</section>

<?php include 'includes/footer.php'; ?>
