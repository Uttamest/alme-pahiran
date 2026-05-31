<?php
require_once '../config/init.php';

unset($_SESSION['admin_id'], $_SESSION['admin_username']);
set_flash('success', 'Admin logged out.');
redirect('login.php');
?>
