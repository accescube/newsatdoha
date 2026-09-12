<?php
// currency.php - Qatar Riyal Live Exchange Rate Center
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/widgets.php';

$settings = get_settings();
$rates = $settings['exchange_rates']['rates'] ?? [];
$pageTitle = t('Qatar Riyal Exchange Rates & Live Converter', 'ഖത്തർ റിയാൽ വിനിമയ നിരക്കുകൾ');
$pageDesc = t('Live Qatar Riyal (QAR) conversion rates to Indian Rupee (INR), Pakistani Rupee (PKR), Bangladeshi Taka (BDT), Philippine Peso (PHP), and US Dollar.', 
              'ഖത്തർ റിയാൽ ലൈവ് വിനിമയ നിരക്കുകളും കറൻസി കാൽക്കുലേറ്ററും.');

include __DIR__ . '/includes/header.php';
?>

<main class="container my-4">
    <!-- Header -->
    <div class="p-4 p-md-5 rounded shadow-sm mb-4 text-white" style="background: linear-gradient(135deg, #198754 0%, #0c3e26 100%);">
        <span class="badge bg-gold text-dark mb-2 text-uppercase fw-bold"><i class="fas fa-coins me-1"></i> <?= t('Financial Desk', 'ഫിനാൻഷ്യൽ ഡെസ്ക്') ?></span>
        <h1 class="display-6 fw-bold mb-2">
            <?= t('Qatar Riyal (QAR) Live Exchange Center', 'ഖത്തർ റിയാൽ ഇന്നത്തെ വിനിമയ നിരക്കുകൾ') ?>
        </h1>
        <p class="lead fs-6 text-white-50 mb-0">
            <?= t('Real-time indicative exchange rates for expatriate remittances from Doha, Qatar across South Asian, Southeast Asian, and major world currencies.',
                  'ഖത്തറിൽ നിന്നും ഇന്ത്യ, പാകിസ്ഥാൻ, ബംഗ്ലാദേശ്, ഫിലിപ്പീൻസ്, നേപ്പാൾ തുടങ്ങിയ രാജ്യങ്ങളിലേക്കുള്ള പണമയക്കൽ നിരക്കുകൾ.') ?>
        </p>
    </div>

    <div class="row g-4">
        <!-- LEFT: CALCULATOR & TABLE (8 of 12) -->
        <div class="col-lg-8">
            
            <!-- INTERACTIVE CALCULATOR CARD -->
            <div class="card shadow-sm border mb-4">
                <div class="card-header bg-maroon text-white py-3">
                    <h4 class="mb-0 fw-bold fs-5">
                        <i class="fas fa-calculator me-2 text-warning"></i>
                        <?= t('Live Currency Calculator', 'തത്സമയ കറൻസി കാൽക്കുലേറ്റർ') ?>
                    </h4>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3 align-items-end mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold"><?= t('Send Amount from Qatar:', 'അയക്കുന്ന തുക (ഖത്തർ റിയാൽ):') ?></label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-light fw-bold text-maroon">QAR</span>
                                <input type="number" id="calc-qar-amount" class="form-control fw-bold" value="500" min="1" step="any">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="alert alert-light border mb-0 py-2 text-muted small">
                                <i class="fas fa-info-circle me-1 text-primary"></i>
                                <?= t('Rates are benchmark market averages updated daily for Doha remitters.', 'ദോഹയിലെ പ്രധാന എക്സ്ചേഞ്ചുകളിലെ ശരാശരി നിരക്കാണിത്.') ?>
                            </div>
                        </div>
                    </div>

                    <!-- Output Cards Grid -->
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="p-3 border rounded bg-light d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="fs-4 me-2">🇮🇳</span>
                                    <strong>Indian Rupee (INR)</strong>
                                    <div class="small text-muted">1 QAR = <?= $rates['INR'] ?? 22.85 ?> INR</div>
                                </div>
                                <div class="text-end">
                                    <h4 class="fw-bold text-maroon mb-0" id="rate-inr" data-rate="<?= $rates['INR'] ?? 22.85 ?>">--</h4>
                                    <span class="small text-muted">INR</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="p-3 border rounded bg-light d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="fs-4 me-2">🇵🇰</span>
                                    <strong>Pakistani Rupee (PKR)</strong>
                                    <div class="small text-muted">1 QAR = <?= $rates['PKR'] ?? 76.45 ?> PKR</div>
                                </div>
                                <div class="text-end">
                                    <h4 class="fw-bold text-maroon mb-0" id="rate-pkr" data-rate="<?= $rates['PKR'] ?? 76.45 ?>">--</h4>
                                    <span class="small text-muted">PKR</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="p-3 border rounded bg-light d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="fs-4 me-2">🇧🇩</span>
                                    <strong>Bangladeshi Taka (BDT)</strong>
                                    <div class="small text-muted">1 QAR = <?= $rates['BDT'] ?? 32.55 ?> BDT</div>
                                </div>
                                <div class="text-end">
                                    <h4 class="fw-bold text-maroon mb-0" id="rate-bdt" data-rate="<?= $rates['BDT'] ?? 32.55 ?>">--</h4>
                                    <span class="small text-muted">BDT</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="p-3 border rounded bg-light d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="fs-4 me-2">🇵🇭</span>
                                    <strong>Philippine Peso (PHP)</strong>
                                    <div class="small text-muted">1 QAR = <?= $rates['PHP'] ?? 15.68 ?> PHP</div>
                                </div>
                                <div class="text-end">
                                    <h4 class="fw-bold text-maroon mb-0" id="rate-php" data-rate="<?= $rates['PHP'] ?? 15.68 ?>">--</h4>
                                    <span class="small text-muted">PHP</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="p-3 border rounded bg-light d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="fs-4 me-2">🇳🇵</span>
                                    <strong>Nepalese Rupee (NPR)</strong>
                                    <div class="small text-muted">1 QAR = <?= $rates['NPR'] ?? 36.56 ?> NPR</div>
                                </div>
                                <div class="text-end">
                                    <h4 class="fw-bold text-maroon mb-0" id="rate-npr" data-rate="<?= $rates['NPR'] ?? 36.56 ?>">--</h4>
                                    <span class="small text-muted">NPR</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="p-3 border rounded bg-light d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="fs-4 me-2">🇺🇸</span>
                                    <strong>US Dollar (USD)</strong>
                                    <div class="small text-muted">1 QAR = $<?= $rates['USD'] ?? 0.274 ?></div>
                                </div>
                                <div class="text-end">
                                    <h4 class="fw-bold text-maroon mb-0" id="rate-usd" data-rate="<?= $rates['USD'] ?? 0.274 ?>">--</h4>
                                    <span class="small text-muted">USD</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- EXCHANGE HOUSES IN DOHA DIRECTORY -->
            <div class="card shadow-sm border mb-4">
                <div class="card-header bg-dark text-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-store me-2 text-warning"></i><?= t('Major Money Exchange Houses in Qatar', 'ഖത്തറിലെ പ്രധാന എക്സ്ചേഞ്ചുകൾ') ?></h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th><?= t('Exchange Name', 'സ്ഥാപനം') ?></th>
                                    <th><?= t('Key Branches', 'ശാഖകൾ') ?></th>
                                    <th><?= t('Customer Service', 'കസ്റ്റമർ കെയർ') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>Al Mirqab Exchange</strong></td>
                                    <td>Grand Hamad St, Al Khor, Industrial Area</td>
                                    <td>+974 4443 6555</td>
                                </tr>
                                <tr>
                                    <td><strong>Lulu Exchange Qatar</strong></td>
                                    <td>D-Ring Road, Gharaffa, Al Meshaf</td>
                                    <td>+974 4434 2200</td>
                                </tr>
                                <tr>
                                    <td><strong>Al Zaman Exchange</strong></td>
                                    <td>Souq Waqif, Bin Mahmoud, Al Rayyan</td>
                                    <td>+974 4444 1448</td>
                                </tr>
                                <tr>
                                    <td><strong>Eastern Exchange</strong></td>
                                    <td>Old Airport, Al Sadd, Industrial Area</td>
                                    <td>+974 4443 9593</td>
                                </tr>
                                <tr>
                                    <td><strong>Al Dar Exchange</strong></td>
                                    <td>West Bay, Salwa Road, Al Wakra</td>
                                    <td>+974 4438 8888</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT: SIDEBAR (4 of 12) -->
        <div class="col-lg-4">
            <aside class="sidebar">
                <?php render_gold_petrol_widget($settings); ?>
                <?php render_facebook_box($settings); ?>
                <?php render_emergency_widget($settings); ?>
            </aside>
        </div>
    </div>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
