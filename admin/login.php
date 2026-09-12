<?php
// admin/login.php - Editorial CMS Login
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once dirname(__DIR__) . '/includes/db.php';

$settings = get_settings();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pin = trim($_POST['pin'] ?? '');
    $validPin = $settings['admin_pin'] ?? 'doha2026';

    if ($pin === $validPin) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: " . base_url('admin/index.php'));
        exit;
    } else {
        $error = 'Invalid administrator passcode. Please try again.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editorial Login | NEWS @ DOHA</title>
    <link rel="icon" type="image/jpeg" href="<?= base_url('assets/img/logo.jpg') ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body {
            background-color: #111418;
            font-family: 'Inter', system-ui, sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            max-width: 420px;
            width: 100%;
            background: #ffffff;
            border-radius: 12px;
            padding: 2.5rem;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
        }
        .bg-maroon {
            background-color: #8A1538;
        }
        .btn-maroon {
            background-color: #8A1538;
            color: #ffffff;
            font-weight: 600;
        }
        .btn-maroon:hover {
            background-color: #650c25;
            color: #ffffff;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="text-center mb-4">
            <img src="<?= base_url('assets/img/logo.jpg') ?>" alt="News At Doha" class="rounded-circle border border-2 mb-3" width="75" height="75">
            <h4 class="fw-bold mb-1">NEWS @ DOHA</h4>
            <p class="text-muted small">Editorial Management Portal</p>
        </div>

        <?php if ($error): ?>
        <div class="alert alert-danger py-2 small mb-3">
            <i class="fas fa-exclamation-triangle me-1"></i> <?= htmlspecialchars($error) ?>
        </div>
        <?php endif; ?>

        <form action="<?= base_url('admin/login.php') ?>" method="POST">
            <div class="mb-3">
                <label class="form-label small fw-bold">Admin Passcode / PIN</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" name="pin" class="form-control" placeholder="Enter admin passcode" required autofocus>
                </div>
                <div class="form-text small">Default demo passcode: <code>doha2026</code></div>
            </div>

            <button type="submit" class="btn btn-maroon w-100 py-2 mb-3">
                <i class="fas fa-sign-in-alt me-1"></i> Log In to Dashboard
            </button>
        </form>

        <div class="text-center">
            <a href="<?= base_url() ?>" class="text-muted small text-decoration-none">
                <i class="fas fa-arrow-left me-1"></i> Back to Public Website
            </a>
        </div>
    </div>
</body>
</html>
