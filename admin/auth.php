<?php
// admin/auth.php - Admin session check
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once dirname(__DIR__) . '/includes/db.php';

function check_admin_auth() {
    if (empty($_SESSION['admin_logged_in'])) {
        header("Location: " . base_url('admin/login.php'));
        exit;
    }
}
?>
