<?php
// includes/widgets.php - Reusable widgets for NEWS @ DOHA

function render_currency_widget($settings) {
    $rates = $settings['exchange_rates']['rates'] ?? [];
    ?>
    <div class="card widget-card shadow-sm mb-4" id="currency-widget">
        <div class="card-header bg-maroon text-white d-flex justify-content-between align-items-center">
            <span class="fw-bold"><i class="fas fa-coins me-2"></i><?= t('QAR Exchange Rates', 'ഖത്തർ റിയാൽ വിനിമയ നിരക്ക്') ?></span>
            <span class="badge bg-gold text-dark"><?= t('Live Converter', 'കൺവെർട്ടർ') ?></span>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label small text-muted"><?= t('Amount in Qatar Riyal (QAR):', 'ഖത്തർ റിയാൽ (QAR):') ?></label>
                <div class="input-group">
                    <span class="input-group-text fw-bold">QAR</span>
                    <input type="number" id="calc-qar-amount" class="form-control fw-bold" value="100" min="1" step="any">
                </div>
            </div>
            
            <div class="currency-rates-list">
                <div class="currency-item d-flex justify-content-between align-items-center py-1 border-bottom">
                    <div>
                        <span class="fi fi-in me-1">🇮🇳</span> <strong>INR</strong> <span class="small text-muted">(India)</span>
                    </div>
                    <div class="text-end">
                        <span class="fw-bold text-maroon" id="rate-inr" data-rate="<?= $rates['INR'] ?? 22.85 ?>">--</span>
                        <div class="small text-muted">1 QAR = <?= $rates['INR'] ?? 22.85 ?> INR</div>
                    </div>
                </div>
                <div class="currency-item d-flex justify-content-between align-items-center py-1 border-bottom">
                    <div>
                        <span class="fi fi-pk me-1">🇵🇰</span> <strong>PKR</strong> <span class="small text-muted">(Pakistan)</span>
                    </div>
                    <div class="text-end">
                        <span class="fw-bold text-maroon" id="rate-pkr" data-rate="<?= $rates['PKR'] ?? 76.45 ?>">--</span>
                        <div class="small text-muted">1 QAR = <?= $rates['PKR'] ?? 76.45 ?> PKR</div>
                    </div>
                </div>
                <div class="currency-item d-flex justify-content-between align-items-center py-1 border-bottom">
                    <div>
                        <span class="fi fi-bd me-1">🇧🇩</span> <strong>BDT</strong> <span class="small text-muted">(Bangladesh)</span>
                    </div>
                    <div class="text-end">
                        <span class="fw-bold text-maroon" id="rate-bdt" data-rate="<?= $rates['BDT'] ?? 32.55 ?>">--</span>
                        <div class="small text-muted">1 QAR = <?= $rates['BDT'] ?? 32.55 ?> BDT</div>
                    </div>
                </div>
                <div class="currency-item d-flex justify-content-between align-items-center py-1 border-bottom">
                    <div>
                        <span class="fi fi-ph me-1">🇵🇭</span> <strong>PHP</strong> <span class="small text-muted">(Philippines)</span>
                    </div>
                    <div class="text-end">
                        <span class="fw-bold text-maroon" id="rate-php" data-rate="<?= $rates['PHP'] ?? 15.68 ?>">--</span>
                        <div class="small text-muted">1 QAR = <?= $rates['PHP'] ?? 15.68 ?> PHP</div>
                    </div>
                </div>
                <div class="currency-item d-flex justify-content-between align-items-center py-1 border-bottom">
                    <div>
                        <span class="fi fi-np me-1">🇳🇵</span> <strong>NPR</strong> <span class="small text-muted">(Nepal)</span>
                    </div>
                    <div class="text-end">
                        <span class="fw-bold text-maroon" id="rate-npr" data-rate="<?= $rates['NPR'] ?? 36.56 ?>">--</span>
                        <div class="small text-muted">1 QAR = <?= $rates['NPR'] ?? 36.56 ?> NPR</div>
                    </div>
                </div>
                <div class="currency-item d-flex justify-content-between align-items-center py-1">
                    <div>
                        <span class="fi fi-us me-1">🇺🇸</span> <strong>USD</strong> <span class="small text-muted">(US Dollar)</span>
                    </div>
                    <div class="text-end">
                        <span class="fw-bold text-maroon" id="rate-usd" data-rate="<?= $rates['USD'] ?? 0.274 ?>">--</span>
                        <div class="small text-muted">1 QAR = $<?= $rates['USD'] ?? 0.274 ?></div>
                    </div>
                </div>
            </div>
            <a href="<?= base_url('currency.php') ?>" class="btn btn-sm btn-outline-maroon w-100 mt-3">
                <i class="fas fa-calculator me-1"></i> <?= t('Open Full Currency Hub', 'പൂർണ്ണ കറൻസി നിരക്കുകൾ') ?>
            </a>
        </div>
    </div>
    <?php
}

function render_prayer_widget($settings) {
    $prayers = $settings['prayer_times_doha'] ?? [];
    ?>
    <div class="card widget-card shadow-sm mb-4">
        <div class="card-header bg-maroon text-white d-flex justify-content-between align-items-center">
            <span class="fw-bold"><i class="fas fa-mosque me-2"></i><?= t('Doha Prayer Times', 'ദോഹ നമസ്കാര സമയം') ?></span>
            <span class="badge bg-gold text-dark"><?= date('d M Y') ?></span>
        </div>
        <div class="card-body p-0">
            <ul class="list-group list-group-flush small">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><i class="far fa-sun text-warning me-2"></i><?= t('Fajr (Dawn)', 'സുബഹി') ?></span>
                    <strong class="text-maroon"><?= $prayers['fajr'] ?? '04:12 AM' ?></strong>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-sun text-warning me-2"></i><?= t('Sunrise', 'സൂര്യോദയം') ?></span>
                    <span class="text-muted"><?= $prayers['sunrise'] ?? '05:28 AM' ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-cloud-sun text-warning me-2"></i><?= t('Dhuhr (Noon)', 'ളുഹർ') ?></span>
                    <strong class="text-maroon"><?= $prayers['dhuhr'] ?? '11:42 AM' ?></strong>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-cloud-sun-rain text-warning me-2"></i><?= t('Asr (Afternoon)', 'അസർ') ?></span>
                    <strong class="text-maroon"><?= $prayers['asr'] ?? '03:08 PM' ?></strong>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-cloud-moon text-primary me-2"></i><?= t('Maghrib (Sunset)', 'മഗ്‌രിബ്') ?></span>
                    <strong class="text-maroon"><?= $prayers['maghrib'] ?? '05:55 PM' ?></strong>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-moon text-secondary me-2"></i><?= t('Isha (Night)', 'ഇശാ') ?></span>
                    <strong class="text-maroon"><?= $prayers['isha'] ?? '07:25 PM' ?></strong>
                </li>
            </ul>
        </div>
        <div class="card-footer bg-light text-center py-2">
            <small class="text-muted"><?= t('Ministry of Awqaf & Islamic Affairs, Qatar', 'ഔഖാഫ് മന്ത്രാലയം, ഖത്തർ') ?></small>
        </div>
    </div>
    <?php
}

function render_facebook_box($settings) {
    ?>
    <div class="card widget-card shadow-sm mb-4 border-primary">
        <div class="card-header bg-primary text-white d-flex align-items-center">
            <i class="fab fa-facebook-f fa-lg me-2"></i>
            <div>
                <div class="fw-bold">News At Doha on Facebook</div>
                <div class="small text-white-50">@newsatdoha2018</div>
            </div>
        </div>
        <div class="card-body text-center p-4">
            <div class="mb-3">
                <img src="<?= base_url('assets/img/logo.jpg') ?>" alt="News At Doha" class="rounded-circle shadow-sm border border-2" width="75" height="75">
            </div>
            <h5 class="card-title fw-bold mb-1">News At Doha</h5>
            <p class="small text-muted mb-2">
                <span class="badge bg-secondary me-1"><i class="fas fa-thumbs-up me-1"></i><?= $settings['facebook_likes'] ?? '12,213' ?> Followers</span>
                <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Official Page</span>
            </p>
            <p class="card-text small text-secondary">
                <?= t('Follow our official Facebook page for real-time Doha breaking alerts, community live videos, and expat updates.', 'ഖത്തറിലെ പ്രധാന വാർത്തകളും ലൈവ് അപ്‌ഡേറ്റുകളും തത്സമയം അറിയാൻ ഞങ്ങളുടെ ഫേസ്ബുക്ക് പേജ് ഫോളോ ചെയ്യുക.') ?>
            </p>
            <div class="d-grid gap-2">
                <a href="<?= htmlspecialchars($settings['facebook_url']) ?>" target="_blank" rel="noopener" class="btn btn-primary btn-sm">
                    <i class="fab fa-facebook me-1"></i> <?= t('Visit & Follow on Facebook', 'ഫേസ്ബുക്കിൽ ഫോളോ ചെയ്യുക') ?>
                </a>
                <a href="<?= htmlspecialchars($settings['whatsapp_channel'] ?? '#') ?>" target="_blank" rel="noopener" class="btn btn-outline-success btn-sm">
                    <i class="fab fa-whatsapp me-1"></i> <?= t('Join WhatsApp Channel', 'വാട്സ്ആപ്പ് ചാനലിൽ ചേരുക') ?>
                </a>
            </div>
        </div>
    </div>
    <?php
}

function render_gold_petrol_widget($settings) {
    $gold = $settings['gold_rates_doha'] ?? [];
    $fuel = $settings['fuel_prices_doha'] ?? [];
    ?>
    <div class="card widget-card shadow-sm mb-4">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <span class="fw-bold"><i class="fas fa-gas-pump me-2 text-warning"></i><?= t('Qatar Fuel & Gold', 'ഇന്ധന & സ്വർണ്ണവില') ?></span>
            <span class="badge bg-gold text-dark"><?= t('Official', 'ഔദ്യോഗികം') ?></span>
        </div>
        <div class="card-body">
            <h6 class="text-maroon fw-bold small text-uppercase mb-2"><i class="fas fa-ring me-1"></i><?= t('Doha Gold Rate (per gram)', 'ദോഹ സ്വർണ്ണവില (ഗ്രാമിന്)') ?></h6>
            <div class="row g-2 text-center mb-3">
                <div class="col-4">
                    <div class="p-2 border rounded bg-light">
                        <div class="small text-muted">24K Gold</div>
                        <div class="fw-bold text-dark"><?= $gold['gram_24k'] ?? '312.50' ?> <span class="small">QAR</span></div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="p-2 border rounded bg-light">
                        <div class="small text-muted">22K Gold</div>
                        <div class="fw-bold text-maroon"><?= $gold['gram_22k'] ?? '290.00' ?> <span class="small">QAR</span></div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="p-2 border rounded bg-light">
                        <div class="small text-muted">18K Gold</div>
                        <div class="fw-bold text-dark"><?= $gold['gram_18k'] ?? '237.25' ?> <span class="small">QAR</span></div>
                    </div>
                </div>
            </div>
            
            <h6 class="text-maroon fw-bold small text-uppercase mb-2"><i class="fas fa-oil-can me-1"></i><?= t('Qatar Energy Fuel Prices', 'ഖത്തർ എനർജി പെട്രോൾ നിരക്ക്') ?></h6>
            <div class="row g-2 text-center">
                <div class="col-4">
                    <div class="p-2 border rounded bg-light">
                        <div class="small text-muted">Premium 91</div>
                        <div class="fw-bold"><?= $fuel['premium_91'] ?? '1.95' ?> <span class="small">QAR</span></div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="p-2 border rounded bg-light">
                        <div class="small text-muted">Super 95</div>
                        <div class="fw-bold"><?= $fuel['super_95'] ?? '2.10' ?> <span class="small">QAR</span></div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="p-2 border rounded bg-light">
                        <div class="small text-muted">Diesel</div>
                        <div class="fw-bold"><?= $fuel['diesel'] ?? '2.05' ?> <span class="small">QAR</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}

function render_emergency_widget($settings) {
    $helplines = array_slice($settings['emergency_helplines'] ?? [], 0, 5);
    ?>
    <div class="card widget-card shadow-sm mb-4 border-danger">
        <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
            <span class="fw-bold"><i class="fas fa-phone-volume me-2"></i><?= t('Qatar Emergency Numbers', 'ഖത്തർ അത്യാഹിത നമ്പറുകൾ') ?></span>
            <a href="<?= base_url('directory.php') ?>" class="text-white text-decoration-none small"><?= t('View All', 'മുഴുവൻ') ?> &rarr;</a>
        </div>
        <div class="card-body p-0">
            <div class="list-group list-group-flush small">
                <?php foreach ($helplines as $hl): ?>
                <a href="tel:<?= preg_replace('/[^0-9+]/', '', $hl['number']) ?>" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    <div>
                        <div class="fw-bold"><?= t($hl['name_en'], $hl['name_ml']) ?></div>
                        <span class="badge bg-secondary"><?= $hl['badge'] ?></span>
                    </div>
                    <span class="btn btn-sm btn-outline-danger fw-bold"><i class="fas fa-phone me-1"></i><?= $hl['number'] ?></span>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php
}

function render_trending_articles($limit = 5) {
    $articles = get_articles(null, null, $limit);
    ?>
    <div class="card widget-card shadow-sm mb-4">
        <div class="card-header bg-maroon text-white">
            <span class="fw-bold"><i class="fas fa-fire me-2 text-warning"></i><?= t('Trending in Qatar', 'ഖത്തറിൽ തരംഗമാകുന്നവ') ?></span>
        </div>
        <div class="card-body p-0">
            <div class="list-group list-group-flush">
                <?php $i = 1; foreach ($articles as $art): ?>
                <a href="<?= base_url('article.php?id=' . urlencode($art['id'])) ?>" class="list-group-item list-group-item-action py-3">
                    <div class="d-flex w-100">
                        <span class="trending-rank me-3"><?= $i++ ?></span>
                        <div>
                            <h6 class="mb-1 fw-bold lh-sm text-dark title-hover">
                                <?= htmlspecialchars(t($art['title_en'], $art['title_ml'])) ?>
                            </h6>
                            <small class="text-muted">
                                <i class="far fa-clock me-1"></i><?= date('d M Y', strtotime($art['date'])) ?>
                                &bull; <span class="badge bg-light text-secondary border"><?= ucfirst($art['category']) ?></span>
                            </small>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php
}
?>
