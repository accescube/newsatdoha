<?php
// includes/footer.php - Global Footer for NEWS @ DOHA
require_once __DIR__ . '/db.php';
$settings = get_settings();
$categories = get_categories();
?>
    <!-- Global Footer -->
    <footer class="site-footer bg-dark text-white pt-5 pb-3 mt-5">
        <div class="container">
            <div class="row g-4 pb-4 border-bottom border-secondary">
                <!-- Col 1: Brand & Bio -->
                <div class="col-lg-4 col-md-6">
                    <div class="d-flex align-items-center mb-3">
                        <img src="<?= base_url('assets/img/logo.jpg') ?>" alt="News At Doha" class="rounded bg-white p-1 me-3" width="60" height="60">
                        <div>
                            <h5 class="mb-0 fw-bold text-white tracking-wide">NEWS @ DOHA</h5>
                            <small class="text-gold"><?= t('Official Qatar News Portal', 'ഖത്തറിലെ പ്രധാന വാർത്താ പോർട്ടൽ') ?></small>
                        </div>
                    </div>
                    <p class="text-white-50 small mb-3">
                        <?= t('Your primary digital destination for authentic Qatar national news, residency and visa regulations, economy, Indian and Asian expatriate affairs, and community developments across Doha.', 
                              'ഖത്തറിലെ പ്രധാന വാർത്തകൾ, തൊഴിൽ-വിസ നിയമങ്ങൾ, പ്രവാസി കൂട്ടായ്മകൾ, വിനിമയ നിരക്കുകൾ എന്നിവ വിശ്വസനീയമായി മലയാളത്തിലും ഇംഗ്ലീഷിലും കൃത്യതയോടെ നിങ്ങളിലേക്ക് എത്തിക്കുന്നു.') ?>
                    </p>
                    
                    <!-- Facebook Social Badge -->
                    <div class="p-3 rounded bg-secondary bg-opacity-25 border border-secondary mb-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <i class="fab fa-facebook text-primary fs-3 me-2"></i>
                                <div>
                                    <div class="fw-bold small text-white">News At Doha</div>
                                    <div class="small text-white-50">12,213+ Followers</div>
                                </div>
                            </div>
                            <a href="<?= htmlspecialchars($settings['facebook_url']) ?>" target="_blank" rel="noopener" class="btn btn-sm btn-primary">
                                <i class="fas fa-thumbs-up me-1"></i> <?= t('Follow', 'ഫോളോ') ?>
                            </a>
                        </div>
                    </div>

                    <!-- Social Media Links -->
                    <div class="social-links d-flex gap-2">
                        <a href="<?= htmlspecialchars($settings['facebook_url']) ?>" target="_blank" rel="noopener" class="social-btn btn btn-sm btn-outline-light rounded-circle" title="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="<?= htmlspecialchars($settings['whatsapp_channel'] ?? '#') ?>" target="_blank" rel="noopener" class="social-btn btn btn-sm btn-outline-light rounded-circle" title="WhatsApp Channel">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="<?= htmlspecialchars($settings['youtube_url'] ?? '#') ?>" target="_blank" rel="noopener" class="social-btn btn btn-sm btn-outline-light rounded-circle" title="YouTube">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a href="<?= htmlspecialchars($settings['instagram_url'] ?? '#') ?>" target="_blank" rel="noopener" class="social-btn btn btn-sm btn-outline-light rounded-circle" title="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="<?= htmlspecialchars($settings['x_url'] ?? '#') ?>" target="_blank" rel="noopener" class="social-btn btn btn-sm btn-outline-light rounded-circle" title="X (Twitter)">
                            <i class="fab fa-x-twitter"></i>
                        </a>
                    </div>
                </div>

                <!-- Col 2: Categories -->
                <div class="col-lg-2 col-md-6">
                    <h6 class="text-uppercase fw-bold text-gold mb-3"><?= t('Categories', 'വിഭാഗങ്ങൾ') ?></h6>
                    <ul class="list-unstyled footer-links small">
                        <?php foreach ($categories as $cat): ?>
                        <li class="mb-2">
                            <a href="<?= base_url('category.php?cat=' . urlencode($cat['id'])) ?>" class="text-white-50 text-decoration-none hover-white">
                                <i class="fas fa-angle-right me-1 text-gold"></i> <?= t($cat['name_en'], $cat['name_ml']) ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                        <li class="mb-2">
                            <a href="<?= base_url('expat-guide.php') ?>" class="text-white-50 text-decoration-none hover-white">
                                <i class="fas fa-angle-right me-1 text-gold"></i> <?= t('Expat Guide', 'പ്രവാസി ഗൈഡ്') ?>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Col 3: Expat Services & Quick Links -->
                <div class="col-lg-3 col-md-6">
                    <h6 class="text-uppercase fw-bold text-gold mb-3"><?= t('Qatar Utilities', 'സേവനങ്ങൾ') ?></h6>
                    <ul class="list-unstyled footer-links small">
                        <li class="mb-2">
                            <a href="<?= base_url('currency.php') ?>" class="text-white-50 text-decoration-none hover-white">
                                <i class="fas fa-exchange-alt me-1 text-gold"></i> <?= t('Live QAR Currency Rates', 'ഖത്തർ റിയാൽ വിനിമയ നിരക്ക്') ?>
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="<?= base_url('prayer-times.php') ?>" class="text-white-50 text-decoration-none hover-white">
                                <i class="fas fa-mosque me-1 text-gold"></i> <?= t('Doha Prayer Timings', 'ദോഹ നമസ്കാര സമയം') ?>
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="<?= base_url('directory.php') ?>" class="text-white-50 text-decoration-none hover-white">
                                <i class="fas fa-phone-alt me-1 text-gold"></i> <?= t('Emergency & Helplines', 'അത്യാഹിത നമ്പറുകൾ (999)') ?>
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="<?= base_url('expat-guide.php#metrash2') ?>" class="text-white-50 text-decoration-none hover-white">
                                <i class="fas fa-laptop me-1 text-gold"></i> <?= t('Metrash2 & QID Renewal', 'മെട്രാഷ്2 സേവനങ്ങൾ') ?>
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="<?= base_url('expat-guide.php#labour') ?>" class="text-white-50 text-decoration-none hover-white">
                                <i class="fas fa-balance-scale me-1 text-gold"></i> <?= t('Qatar Labour Law', 'ഖത്തർ തൊഴിൽ നിയമം') ?>
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="<?= base_url('admin/index.php') ?>" class="text-white-50 text-decoration-none hover-white">
                                <i class="fas fa-shield-alt me-1 text-gold"></i> <?= t('Editorial Panel Login', 'എഡിറ്റോറിയൽ ലോഗിൻ') ?>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Col 4: Newsletter & WhatsApp Alerts -->
                <div class="col-lg-3 col-md-6">
                    <h6 class="text-uppercase fw-bold text-gold mb-3"><?= t('Daily News Alerts', 'വാർത്തകൾ വാട്സ്ആപ്പിൽ') ?></h6>
                    <p class="text-white-50 small mb-3">
                        <?= t('Get breaking Qatar headlines and weekly expat advisories directly to your WhatsApp or inbox.', 'ഖത്തറിലെ പ്രധാന വാർത്തകൾ ഉടൻ ലഭിക്കാൻ സബ്സ്ക്രൈബ് ചെയ്യുക.') ?>
                    </p>
                    <form id="footer-subscribe-form" class="mb-3">
                        <div class="input-group mb-2">
                            <input type="text" id="sub-phone-email" class="form-control form-control-sm" placeholder="<?= t('WhatsApp Number or Email', 'വാട്സ്ആപ്പ് നമ്പർ / ഇമെയിൽ') ?>" required>
                            <button class="btn btn-sm btn-maroon" type="submit">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                        <div id="sub-feedback" class="small"></div>
                    </form>
                    <div class="small text-white-50">
                        <i class="fas fa-map-marker-alt text-gold me-1"></i> Doha, State of Qatar<br>
                        <i class="fas fa-envelope text-gold me-1"></i> <?= $settings['contact_email'] ?? 'contact@newsatdoha.com' ?>
                    </div>
                </div>
            </div>

            <!-- Bottom Copyright -->
            <div class="row pt-3 align-items-center small text-white-50">
                <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
                    &copy; 2018 - <?= date('Y') ?> <strong class="text-white">NEWS @ DOHA</strong>. <?= t('All Rights Reserved.', 'എല്ലാ അവകാശങ്ങളും നിക്ഷിപ്തം.') ?>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <span><?= t('Independent Expatriate & Qatar Media Portal', 'ഖത്തർ വാർത്താ & പ്രവാസി പോർട്ടൽ') ?></span>
                    &bull; <a href="<?= htmlspecialchars($settings['facebook_url']) ?>" target="_blank" rel="noopener" class="text-white-50 text-decoration-none">fb.com/newsatdoha2018</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button id="back-to-top" class="btn btn-maroon rounded-circle shadow" title="Back to top" aria-label="Back to top">
        <i class="fas fa-chevron-up"></i>
    </button>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- App Main JS -->
    <script src="<?= base_url('assets/js/main.js') ?>"></script>
</body>
</html>
