<?php
require_once 'config/init.php';

unset($_SESSION['user_id']);
set_flash('success', 'You have logged out.');
redirect('index.php');
?>