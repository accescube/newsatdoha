<?php
// admin/settings.php - Portal Settings & Daily Rates Editor
require_once __DIR__ . '/auth.php';
check_admin_auth();

$settings = get_settings();
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update basic settings
    $settings['site_tagline_en'] = trim($_POST['site_tagline_en'] ?? $settings['site_tagline_en']);
    $settings['site_tagline_ml'] = trim($_POST['site_tagline_ml'] ?? $settings['site_tagline_ml']);
    $settings['facebook_likes'] = trim($_POST['facebook_likes'] ?? $settings['facebook_likes']);
    $settings['facebook_url'] = trim($_POST['facebook_url'] ?? $settings['facebook_url']);
    $settings['whatsapp_channel'] = trim($_POST['whatsapp_channel'] ?? $settings['whatsapp_channel']);
    
    // Admin PIN update if provided
    if (!empty($_POST['admin_pin'])) {
        $settings['admin_pin'] = trim($_POST['admin_pin']);
    }

    // Exchange rates
    $settings['exchange_rates']['rates']['INR'] = floatval($_POST['rate_inr'] ?? 22.85);
    $settings['exchange_rates']['rates']['PKR'] = floatval($_POST['rate_pkr'] ?? 76.45);
    $settings['exchange_rates']['rates']['BDT'] = floatval($_POST['rate_bdt'] ?? 32.55);
    $settings['exchange_rates']['rates']['PHP'] = floatval($_POST['rate_php'] ?? 15.68);
    $settings['exchange_rates']['rates']['NPR'] = floatval($_POST['rate_npr'] ?? 36.56);
    $settings['exchange_rates']['rates']['USD'] = floatval($_POST['rate_usd'] ?? 0.274);

    // Gold rates
    $settings['gold_rates_doha']['gram_24k'] = floatval($_POST['gold_24k'] ?? 312.50);
    $settings['gold_rates_doha']['gram_22k'] = floatval($_POST['gold_22k'] ?? 290.00);
    $settings['gold_rates_doha']['gram_18k'] = floatval($_POST['gold_18k'] ?? 237.25);

    // Fuel rates
    $settings['fuel_prices_doha']['premium_91'] = trim($_POST['fuel_91'] ?? '1.95');
    $settings['fuel_prices_doha']['super_95'] = trim($_POST['fuel_95'] ?? '2.10');
    $settings['fuel_prices_doha']['diesel'] = trim($_POST['fuel_diesel'] ?? '2.05');

    save_settings($settings);
    $msg = 'Settings and daily rates updated successfully!';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings & Rates | NEWS @ DOHA Editorial</title>
    <link rel="icon" type="image/jpeg" href="<?= base_url('assets/img/logo.jpg') ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Inter', system-ui, sans-serif;
        }
        .bg-maroon {
            background-color: #8A1538;
        }
        .btn-maroon {
            background-color: #8A1538;
            color: #ffffff;
        }
        .btn-maroon:hover {
            background-color: #630c24;
            color: #ffffff;
        }
        .sidebar-admin {
            min-height: 100vh;
            background-color: #111418;
            color: #ffffff;
        }
        .sidebar-admin .nav-link {
            color: #9ca3af;
            padding: 0.75rem 1rem;
            border-radius: 6px;
            margin-bottom: 0.25rem;
        }
        .sidebar-admin .nav-link:hover, .sidebar-admin .nav-link.active {
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar-admin p-3 collapse">
                <div class="d-flex align-items-center mb-4 pb-3 border-bottom border-secondary">
                    <img src="<?= base_url('assets/img/logo.jpg') ?>" alt="News At Doha" class="rounded me-2" width="40" height="40">
                    <div>
                        <h6 class="mb-0 fw-bold text-white">NEWS @ DOHA</h6>
                        <small class="text-secondary">CMS v1.0</small>
                    </div>
                </div>

                <ul class="nav flex-column mb-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('admin/index.php') ?>">
                            <i class="fas fa-newspaper me-2"></i> All Articles
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('admin/edit.php') ?>">
                            <i class="fas fa-plus-circle me-2"></i> New Article
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="<?= base_url('admin/settings.php') ?>">
                            <i class="fas fa-cog me-2"></i> Site Settings & Rates
                        </a>
                    </li>
                    <li class="nav-item mt-3 pt-3 border-top border-secondary">
                        <a class="nav-link text-info" href="<?= base_url() ?>" target="_blank">
                            <i class="fas fa-external-link-alt me-2"></i> Live Website
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="<?= base_url('admin/logout.php') ?>">
                            <i class="fas fa-sign-out-alt me-2"></i> Log Out
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2 pb-3 mb-4 border-bottom">
                    <div>
                        <h1 class="h3 fw-bold text-dark mb-1">Site Settings & Daily Rates</h1>
                        <p class="text-muted small mb-0">Update daily Doha exchange rates, gold prices, petrol rates, and social counters.</p>
                    </div>
                </div>

                <?php if ($msg): ?>
                <div class="alert alert-success alert-dismissible fade show py-2" role="alert">
                    <i class="fas fa-check-circle me-1"></i> <?= htmlspecialchars($msg) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>

                <form action="" method="POST" class="card border-0 shadow-sm p-4">
                    <!-- SECTION 1: EXCHANGE RATES -->
                    <h5 class="fw-bold text-maroon mb-3 border-bottom pb-2">
                        <i class="fas fa-coins me-2"></i>Qatar Riyal (QAR) Daily Exchange Rates
                    </h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">1 QAR to INR (India)</label>
                            <input type="number" step="0.01" name="rate_inr" class="form-control" value="<?= $settings['exchange_rates']['rates']['INR'] ?? 22.85 ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">1 QAR to PKR (Pakistan)</label>
                            <input type="number" step="0.01" name="rate_pkr" class="form-control" value="<?= $settings['exchange_rates']['rates']['PKR'] ?? 76.45 ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">1 QAR to BDT (Bangladesh)</label>
                            <input type="number" step="0.01" name="rate_bdt" class="form-control" value="<?= $settings['exchange_rates']['rates']['BDT'] ?? 32.55 ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">1 QAR to PHP (Philippines)</label>
                            <input type="number" step="0.01" name="rate_php" class="form-control" value="<?= $settings['exchange_rates']['rates']['PHP'] ?? 15.68 ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">1 QAR to NPR (Nepal)</label>
                            <input type="number" step="0.01" name="rate_npr" class="form-control" value="<?= $settings['exchange_rates']['rates']['NPR'] ?? 36.56 ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">1 QAR to USD (US Dollar)</label>
                            <input type="number" step="0.001" name="rate_usd" class="form-control" value="<?= $settings['exchange_rates']['rates']['USD'] ?? 0.274 ?>">
                        </div>
                    </div>

                    <!-- SECTION 2: GOLD & FUEL -->
                    <h5 class="fw-bold text-maroon mb-3 border-bottom pb-2">
                        <i class="fas fa-ring me-2"></i>Doha Gold Rates & Fuel Prices
                    </h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">24K Gold (QAR / gram)</label>
                            <input type="number" step="0.25" name="gold_24k" class="form-control" value="<?= $settings['gold_rates_doha']['gram_24k'] ?? 312.50 ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">22K Gold (QAR / gram)</label>
                            <input type="number" step="0.25" name="gold_22k" class="form-control" value="<?= $settings['gold_rates_doha']['gram_22k'] ?? 290.00 ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">18K Gold (QAR / gram)</label>
                            <input type="number" step="0.25" name="gold_18k" class="form-control" value="<?= $settings['gold_rates_doha']['gram_18k'] ?? 237.25 ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Premium 91 Petrol (QAR / L)</label>
                            <input type="text" name="fuel_91" class="form-control" value="<?= $settings['fuel_prices_doha']['premium_91'] ?? '1.95' ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Super 95 Petrol (QAR / L)</label>
                            <input type="text" name="fuel_95" class="form-control" value="<?= $settings['fuel_prices_doha']['super_95'] ?? '2.10' ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Diesel (QAR / L)</label>
                            <input type="text" name="fuel_diesel" class="form-control" value="<?= $settings['fuel_prices_doha']['diesel'] ?? '2.05' ?>">
                        </div>
                    </div>

                    <!-- SECTION 3: SOCIAL & PORTAL -->
                    <h5 class="fw-bold text-maroon mb-3 border-bottom pb-2">
                        <i class="fab fa-facebook me-2"></i>Social Presence & Admin Passcode
                    </h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Facebook Page URL</label>
                            <input type="url" name="facebook_url" class="form-control" value="<?= htmlspecialchars($settings['facebook_url'] ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Facebook Follower Count Display</label>
                            <input type="text" name="facebook_likes" class="form-control" value="<?= htmlspecialchars($settings['facebook_likes'] ?? '12,213') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">WhatsApp Channel Link</label>
                            <input type="url" name="whatsapp_channel" class="form-control" value="<?= htmlspecialchars($settings['whatsapp_channel'] ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Change Admin Passcode / PIN</label>
                            <input type="text" name="admin_pin" class="form-control" value="<?= htmlspecialchars($settings['admin_pin'] ?? 'doha2026') ?>">
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-maroon px-4 py-2 fw-bold">
                            <i class="fas fa-save me-1"></i> Save All Settings
                        </button>
                    </div>
                </form>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
