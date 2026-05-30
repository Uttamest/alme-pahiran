<?php
require_once '../config/init.php';

if (!empty($_SESSION['admin_id'])) {
    redirect('dashboard.php');
}

$page_title = 'Admin Login - AlMe Pahiran';
$errors = [];
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf()) {
        $errors[] = 'Invalid form submission.';
    }

    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $errors[] = 'Username and password are required.';
    }

    if (count($errors) === 0) {
        $admin = get_one($conn, 'SELECT * FROM admins WHERE username = ? LIMIT 1', 's', [$username]);

        if ($admin && password_verify($password, $admin['password'])) {
            session_regenerate_id(true);
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            redirect('dashboard.php');
        }

        $errors[] = 'Invalid admin login.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo h($page_title); ?></title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="login-page">
    <main class="login-box">
        <h1>AlMe Pahiran Admin</h1>
        <p>Manage products, orders, users, categories, and homepage banners.</p>

        <?php if (count($errors) > 0): ?>
            <div class="message error">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo h($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="post" class="form-box">
            <?php echo csrf_field(); ?>
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="<?php echo h($username); ?>" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
        </form>

        <p class="small-text">Default admin: admin / admin123</p>
        <p><a href="../index.php">Back to store</a></p>
    </main>
</body>
</html>
