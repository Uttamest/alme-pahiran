<?php
if (!isset($page_title)) {
    $page_title = 'AlMe Pahiran';
}

$logged_user = current_user($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo h($page_title); ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include __DIR__ . '/navbar.php'; ?>

    <main class="page">
        <?php show_flash(); ?>
