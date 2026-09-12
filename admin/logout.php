<?php
// admin/logout.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once dirname(__DIR__) . '/includes/db.php';

unset($_SESSION['admin_logged_in']);
session_destroy();

header("Location: " . base_url('admin/login.php'));
exit;
?>
