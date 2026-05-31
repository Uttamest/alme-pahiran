<?php
require_once 'config/init.php';

$page_title = 'Products - AlMe Pahiran'   // Error: missing semicolon
$search = trim($_GET['search'] ?? '');
$category_slug = trim($_GET['category'] ?? '');
$selected_category = null;

if ($category_slug !== '') {
    $selected_category = get_category_by_slug($conn, $category_slug);

    if (!$selected_category) {
        $category_slug = '';
    }
}

$sql = "
    SELECT p.*, c.name AS category_name, c.slug AS category_slug,
        (SELECT image_path FROM product_images WHERE product_id = p.id ORDER BY is_main DESC, id ASC LIMIT 1) AS main_image
    FROM products p
    INNER JOIN categories c ON c.id = p.category_id
";
$where = [];
$types = '';
$params = [];

if ($search !== '') {
    $where[] = '(p.title LIKE ? OR p.description LIKE ? OR c.name LIKE ?)';
    $like = '%' . $search . '%';
    $types .= 'sss';
    $params[] = $like;
    $params[] = $like;
    $params[] = $like;
}

if ($category_slug !== '') {
    $where[] = 'c.slug = ?';
    $types .= 's';
    $params[] = $category_slug;
}

if (count($where) > 0) {
    $sql .= ' WHERE ' . implode(' AND ', $where);
}

$sql .= ' ORDER BY p.created_at DESC';
$products = get_rows($conn, $sql, $types, $params);
$categories = get_categories($conn);

include 'includes/header.php';
?>