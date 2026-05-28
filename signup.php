<?php
require_once 'config/init.php';

if (is_logged_in()) {
    redirect('profile.php');
}

$page_title = 'Signup - AlMe Pahiran';
$errors = [];
$full_name = '';
$email = '';
$address = '';
$phone = '';
$social_link = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf()) {
        $errors[] = 'Invalid form submission.';
    }

    $full_name = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $social_link = trim($_POST['social_link'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if ($full_name === '') {
        $errors[] = 'Full name is required.';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'A valid email is required.';
    }

    if (strlen($password) < 6) {
        $errors[] = 'Password must be at least 6 characters.';
    }

    if ($password !== $confirm_password) {
        $errors[] = 'Passwords do not match.';
    }

    if ($phone !== '' && !preg_match('/^[0-9+\-\s]{7,20}$/', $phone)) {
        $errors[] = 'Please enter a valid phone number.';
    }

    $existing = get_one($conn, 'SELECT id FROM users WHERE email = ? LIMIT 1', 's', [$email]);

    if ($existing) {
        $errors[] = 'This email is already registered.';
    }

    if (count($errors) === 0) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        run_query(
            $conn,
            'INSERT INTO users (full_name, email, password, address, phone, social_link)
             VALUES (?, ?, ?, ?, ?, ?)',
            'ssssss',
            [$full_name, $email, $hashed_password, $address, $phone, $social_link]
        );

        $_SESSION['user_id'] = mysqli_insert_id($conn);
        session_regenerate_id(true);

        set_flash('success', 'Account created successfully.');
        redirect('profile.php');
    }
}

include 'includes/header.php';
?>

<section class="auth-layout">
    <div class="auth-info">
        <p class="eyebrow">Create Account</p>
        <h1>Join AlMe Pahiran</h1>
        <p>Create an account to save your details, place order requests, and view your previous orders.</p>
    </div>

    <form method="post" class="form-box auth-form">
        <?php echo csrf_field(); ?>
        <h2>Signup</h2>

        <?php if (count($errors) > 0): ?>
            <div class="message error">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo h($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <label for="full_name">Full Name</label>
        <input type="text" id="full_name" name="full_name" value="<?php echo h($full_name); ?>" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?php echo h($email); ?>" required>

        <label for="address">Address</label>
        <textarea id="address" name="address" rows="3"><?php echo h($address); ?></textarea>

        <label for="phone">Phone</label>
        <input type="text" id="phone" name="phone" value="<?php echo h($phone); ?>">

        <label for="social_link">Social Media / Contact Link</label>
        <input type="text" id="social_link" name="social_link" value="<?php echo h($social_link); ?>">

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>

        <label for="confirm_password">Confirm Password</label>
        <input type="password" id="confirm_password" name="confirm_password" required>

        <button type="submit">Create Account</button>
        <p class="small-text">Already have an account? <a href="login.php">Login here</a>.</p>
    </form>
</section>

<?php include 'includes/footer.php'; ?>
