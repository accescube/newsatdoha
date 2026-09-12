<?php
// prayer-times.php - Doha Prayer Times & Islamic Calendar
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/widgets.php';

$settings = get_settings();
$prayers = $settings['prayer_times_doha'] ?? [];

$pageTitle = t('Doha Prayer Times & Awqaf Schedule', 'ദോഹ നമസ്കാര സമയം');
$pageDesc = t('Daily prayer times for Doha, Al Rayyan, Al Wakra, and Al Khor as issued by the Ministry of Awqaf and Islamic Affairs, Qatar.',
              'ഖത്തർ ഔഖാഫ് മന്ത്രാലയത്തിന്റെ അംഗീകൃത ദോഹ നമസ്കാര സമയം.');

include __DIR__ . '/includes/header.php';
?>

<main class="container my-4">
    <div class="p-4 p-md-5 rounded shadow-sm mb-4 text-white" style="background: linear-gradient(135deg, #0f5132 0%, #052c10 100%);">
        <span class="badge bg-gold text-dark mb-2 text-uppercase fw-bold"><i class="fas fa-mosque me-1"></i> <?= t('Islamic Affairs', 'ഇസ്ലാമിക് അഫയേഴ്സ്') ?></span>
        <h1 class="display-6 fw-bold mb-2">
            <?= t('Doha Prayer Times Today', 'ഇന്നത്തെ ദോഹ നമസ്കാര സമയം') ?>
        </h1>
        <p class="lead fs-6 text-white-50 mb-0">
            <?= t('Official daily prayer schedule for Doha and surrounding municipalities according to the Ministry of Awqaf and Islamic Affairs, State of Qatar.',
                  'ഖത്തർ ഔഖാഫ് മന്ത്രാലയത്തിന്റെ ഔദ്യോഗിക സമയക്രമം അനുസരിച്ചുള്ള ഇന്നത്തെ പ്രാർത്ഥനാ സമയം.') ?>
        </p>
    </div>

    <div class="row g-4">
        <!-- LEFT: PRAYER TABLE & CARDS (8 of 12) -->
        <div class="col-lg-8">
            <div class="row g-3 mb-4">
                <div class="col-6 col-md-4">
                    <div class="card shadow-sm border text-center p-3 h-100">
                        <i class="far fa-sun fa-2x text-warning mb-2"></i>
                        <h6 class="text-muted text-uppercase small mb-1"><?= t('Fajr (Dawn)', 'സുബഹി') ?></h6>
                        <h3 class="fw-bold text-maroon mb-0"><?= $prayers['fajr'] ?? '04:12 AM' ?></h3>
                    </div>
                </div>
                <div class="col-6 col-md-4">
                    <div class="card shadow-sm border text-center p-3 h-100">
                        <i class="fas fa-sun fa-2x text-warning mb-2"></i>
                        <h6 class="text-muted text-uppercase small mb-1"><?= t('Sunrise', 'സൂര്യോദയം') ?></h6>
                        <h3 class="fw-bold text-secondary mb-0"><?= $prayers['sunrise'] ?? '05:28 AM' ?></h3>
                    </div>
                </div>
                <div class="col-6 col-md-4">
                    <div class="card shadow-sm border text-center p-3 h-100">
                        <i class="fas fa-cloud-sun fa-2x text-warning mb-2"></i>
                        <h6 class="text-muted text-uppercase small mb-1"><?= t('Dhuhr (Noon)', 'ളുഹർ') ?></h6>
                        <h3 class="fw-bold text-maroon mb-0"><?= $prayers['dhuhr'] ?? '11:42 AM' ?></h3>
                    </div>
                </div>
                <div class="col-6 col-md-4">
                    <div class="card shadow-sm border text-center p-3 h-100">
                        <i class="fas fa-cloud-sun-rain fa-2x text-warning mb-2"></i>
                        <h6 class="text-muted text-uppercase small mb-1"><?= t('Asr (Afternoon)', 'അസർ') ?></h6>
                        <h3 class="fw-bold text-maroon mb-0"><?= $prayers['asr'] ?? '03:08 PM' ?></h3>
                    </div>
                </div>
                <div class="col-6 col-md-4">
                    <div class="card shadow-sm border text-center p-3 h-100">
                        <i class="fas fa-cloud-moon fa-2x text-primary mb-2"></i>
                        <h6 class="text-muted text-uppercase small mb-1"><?= t('Maghrib (Sunset)', 'മഗ്‌രിബ്') ?></h6>
                        <h3 class="fw-bold text-maroon mb-0"><?= $prayers['maghrib'] ?? '05:55 PM' ?></h3>
                    </div>
                </div>
                <div class="col-6 col-md-4">
                    <div class="card shadow-sm border text-center p-3 h-100">
                        <i class="fas fa-moon fa-2x text-secondary mb-2"></i>
                        <h6 class="text-muted text-uppercase small mb-1"><?= t('Isha (Night)', 'ഇശാ') ?></h6>
                        <h3 class="fw-bold text-maroon mb-0"><?= $prayers['isha'] ?? '07:25 PM' ?></h3>
                    </div>
                </div>
            </div>

            <!-- Guidelines Card -->
            <div class="card shadow-sm border mb-4">
                <div class="card-header bg-dark text-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-info-circle me-2 text-warning"></i><?= t('Mosque Etiquette & Awqaf Guidelines', 'നിർദ്ദേശങ്ങൾ') ?></h5>
                </div>
                <div class="card-body p-4">
                    <p><?= t('All mosques in the State of Qatar open 20 minutes prior to the Adhan for regular prayers and remain open until the completion of prayer.',
                             'ഖത്തറിലെ എല്ലാ പള്ളികളും അസാൻ കൊടുക്കുന്നതിന് 20 മിനിറ്റ് മുൻപ് തുറക്കപ്പെടുകയും പ്രാർത്ഥനകൾക്ക് ശേഷം അടയ്ക്കുകയും ചെയ്യുന്നു.') ?></p>
                    <ul class="mb-0">
                        <li><strong><?= t('Jummah (Friday) Prayer:', 'ജുമഅ നമസ്കാരം:') ?></strong> <?= t('Khutbah commences approximately 15 minutes before noon Dhuhr prayer time.', 'ളുഹർ സമയത്തിന് 15 മിനിറ്റ് മുൻപ് ഖുതുബ ആരംഭിക്കുന്നു.') ?></li>
                        <li><strong><?= t('Qibla Direction from Doha:', 'ഖിബ്‌ല ദിശ:') ?></strong> 248&deg; WSW (West-Southwest) towards Makkah al-Mukarramah.</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- RIGHT: SIDEBAR (4 of 12) -->
        <div class="col-lg-4">
            <aside class="sidebar">
                <?php render_facebook_box($settings); ?>
                <?php render_emergency_widget($settings); ?>
            </aside>
        </div>
    </div>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
