<?php
// directory.php - Qatar Emergency Numbers & Government Helpline Directory
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/widgets.php';

$settings = get_settings();
$helplines = $settings['emergency_helplines'] ?? [];

$pageTitle = t('Qatar Emergency Numbers & Helplines Directory', 'ഖത്തർ അത്യാഹിത നമ്പറുകൾ');
$pageDesc = t('Essential emergency and helpline telephone numbers in Qatar: 999, Hamad Medical Corporation, Ministry of Interior, Labour ministry, and diplomatic missions.',
              'ഖത്തറിലെ പ്രധാന അത്യാഹിത വിഭാഗം നമ്പറുകൾ, ആശുപത്രികൾ, പോലീസ്, എംബസി നമ്പറുകൾ.');

include __DIR__ . '/includes/header.php';
?>

<main class="container my-4">
    <div class="p-4 p-md-5 rounded shadow-sm mb-4 text-white" style="background: linear-gradient(135deg, #dc3545 0%, #780914 100%);">
        <span class="badge bg-white text-danger mb-2 text-uppercase fw-bold"><i class="fas fa-phone-volume me-1"></i> <?= t('24/7 Helpline Directory', 'അത്യാഹിത ഡയറക്ടറി') ?></span>
        <h1 class="display-6 fw-bold mb-2">
            <?= t('Qatar Emergency & Helpline Directory', 'ഖത്തർ അത്യാഹിത & സഹായ നമ്പറുകൾ') ?>
        </h1>
        <p class="lead fs-6 text-white-50 mb-0">
            <?= t('Verified telephone numbers for emergency services, public healthcare facilities, police departments, and consular missions across Doha, Qatar.',
                  'പോലീസ്, ആംബുലൻസ്, ഫയർഫോഴ്സ്, തൊഴിൽ മന്ത്രാലയം, ആശുപത്രികൾ, ഇന്ത്യൻ എംബസി എന്നിവയുടെ ബന്ധപ്പെടേണ്ട നമ്പറുകൾ.') ?>
        </p>
    </div>

    <!-- PRIMARY 999 EMERGENCY BANNER -->
    <div class="card bg-danger text-white border-0 shadow-sm p-4 mb-4 text-center">
        <div class="row align-items-center">
            <div class="col-md-8 text-md-start mb-3 mb-md-0">
                <h3 class="fw-bold mb-1"><i class="fas fa-ambulance me-2"></i><?= t('General Emergency (Police, Ambulance, Civil Defense)', 'പൊതു അത്യാഹിതം (പോലീസ്, ആംബുലൻസ്, തീപിടുത്തം)') ?></h3>
                <p class="mb-0 text-white-50"><?= t('Available 24 hours a day, 7 days a week, toll-free across all mobile and landline networks in Qatar.', 'ഖത്തറിൽ എവിടെ നിന്നും ഏത് സമയത്തും സൗജന്യമായി വിളിക്കാം.') ?></p>
            </div>
            <div class="col-md-4 text-md-end">
                <a href="tel:999" class="btn btn-light btn-lg text-danger fw-bold fs-3 px-4 shadow">
                    <i class="fas fa-phone-alt me-2"></i> 999
                </a>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- LEFT: DIRECTORY LIST (8 of 12) -->
        <div class="col-lg-8">
            <div class="card shadow-sm border mb-4">
                <div class="card-header bg-maroon text-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-list-ul me-2"></i><?= t('Key Government & Public Helplines', 'പ്രധാന ഹെൽപ്പ്‌ലൈൻ നമ്പറുകൾ') ?></h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <?php foreach ($helplines as $item): ?>
                        <div class="list-group-item p-3 d-flex flex-wrap justify-content-between align-items-center">
                            <div>
                                <h6 class="fw-bold mb-1">
                                    <i class="fas <?= $item['icon'] ?? 'fa-phone' ?> text-maroon me-2"></i>
                                    <?= t($item['name_en'], $item['name_ml']) ?>
                                </h6>
                                <span class="badge bg-secondary"><?= $item['badge'] ?></span>
                            </div>
                            <div class="mt-2 mt-sm-0">
                                <a href="tel:<?= preg_replace('/[^0-9+]/', '', $item['number']) ?>" class="btn btn-outline-danger fw-bold font-monospace">
                                    <i class="fas fa-phone me-1"></i> <?= $item['number'] ?>
                                </a>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- EMBASSIES IN DOHA -->
            <div class="card shadow-sm border mb-4">
                <div class="card-header bg-dark text-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-building me-2 text-warning"></i><?= t('Expat Consular Missions & Diplomatic Helpdesks', 'എംബസി ഹെൽപ്പ്‌ലൈനുകൾ') ?></h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th><?= t('Mission / Forum', 'സ്ഥാപനം') ?></th>
                                    <th><?= t('Location in Doha', 'സ്ഥലം') ?></th>
                                    <th><?= t('Contact Phone', 'ഫോൺ') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>Embassy of India, Doha</strong></td>
                                    <td>Onaiza, West Bay</td>
                                    <td><a href="tel:+97444255777" class="text-maroon fw-bold text-decoration-none">+974 4425 5777</a></td>
                                </tr>
                                <tr>
                                    <td><strong>Indian Community Benevolent Forum (ICBF)</strong></td>
                                    <td>Integrated Indian Community Centre</td>
                                    <td><a href="tel:+97477187499" class="text-maroon fw-bold text-decoration-none">+974 7718 7499</a></td>
                                </tr>
                                <tr>
                                    <td><strong>Embassy of Pakistan, Doha</strong></td>
                                    <td>Diplomatic Area, West Bay</td>
                                    <td><a href="tel:+97444832525" class="text-maroon fw-bold text-decoration-none">+974 4483 2525</a></td>
                                </tr>
                                <tr>
                                    <td><strong>Embassy of Bangladesh, Doha</strong></td>
                                    <td>Al Hilal, Doha</td>
                                    <td><a href="tel:+97444671927" class="text-maroon fw-bold text-decoration-none">+974 4467 1927</a></td>
                                </tr>
                                <tr>
                                    <td><strong>Embassy of the Philippines (POLO / MWO)</strong></td>
                                    <td>Jelaiah Area, Doha</td>
                                    <td><a href="tel:+97444831585" class="text-maroon fw-bold text-decoration-none">+974 4483 1585</a></td>
                                </tr>
                                <tr>
                                    <td><strong>Embassy of Nepal, Doha</strong></td>
                                    <td>Abu Hamour, Doha</td>
                                    <td><a href="tel:+97444675681" class="text-maroon fw-bold text-decoration-none">+974 4467 5681</a></td>
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
                <?php render_facebook_box($settings); ?>
                <?php render_currency_widget($settings); ?>
            </aside>
        </div>
    </div>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
