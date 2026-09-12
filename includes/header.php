<?php
// includes/header.php - Global Header for NEWS @ DOHA
require_once __DIR__ . '/db.php';

$settings = get_settings();
$categories = get_categories();
$breakingItems = get_breaking_news();
$currentLang = get_current_lang();
$activePage = basename($_SERVER['PHP_SELF'], '.php');
$currentCat = $_GET['cat'] ?? '';

// Generate switch language URL
$queryParams = $_GET;
$queryParams['lang'] = ($currentLang === 'ml') ? 'en' : 'ml';
$langSwitchUrl = '?' . http_build_query($queryParams);
?>
<!DOCTYPE html>
<html lang="<?= $currentLang ?>" dir="ltr" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? htmlspecialchars($pageTitle) . ' | ' : '' ?>NEWS @ DOHA | <?= t('Qatar News & Expat Updates', 'ഖത്തറിലെ പ്രധാന വാർത്തകൾ') ?></title>
    
    <!-- Meta Tags -->
    <meta name="description" content="<?= isset($pageDesc) ? htmlspecialchars($pageDesc) : htmlspecialchars(t($settings['site_tagline_en'], $settings['site_tagline_ml'])) ?>">
    <meta name="keywords" content="News at Doha, Qatar News, Doha news today, Qatar expatriates, Metrash2, Qatar visa, Qatar gold rate, Qatar jobs, Malayalam news Qatar, ഖത്തർ വാർത്തകൾ">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= htmlspecialchars((empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]") ?>">
    <meta property="og:title" content="<?= isset($pageTitle) ? htmlspecialchars($pageTitle) . ' | ' : '' ?>NEWS @ DOHA">
    <meta property="og:description" content="<?= isset($pageDesc) ? htmlspecialchars($pageDesc) : htmlspecialchars(t($settings['site_tagline_en'], $settings['site_tagline_ml'])) ?>">
    <meta property="og:image" content="<?= isset($pageImage) ? $pageImage : base_url('assets/img/logo.jpg') ?>">

    <!-- Favicon -->
    <link rel="icon" type="image/jpeg" href="<?= base_url('assets/img/logo.jpg') ?>">
    <link rel="apple-touch-icon" href="<?= base_url('assets/img/logo.jpg') ?>">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@700;900&family=Inter:wght@300;400;500;600;700;800&family=Merriweather:ital,wght@0,300;0,400;0,700;1,300;1,400&family=Noto+Sans+Malayalam:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome 6.5.2 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <!-- Custom Theme CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">

    <!-- Google tag (gtag.js) Firebase Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-YLY5FNJ70W"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'G-YLY5FNJ70W');
    </script>

    <!-- Firebase App & Analytics SDK Module -->
    <script type="module" src="<?= base_url('assets/js/firebase-config.js') ?>"></script>
</head>
<body class="<?= $currentLang === 'ml' ? 'lang-ml' : 'lang-en' ?>">

    <!-- Top Utility Bar -->
    <div class="top-bar py-1 border-bottom">
        <div class="container d-flex flex-wrap justify-content-between align-items-center small">
            <!-- Left Info: Doha Time, Date, Weather -->
            <div class="d-flex align-items-center gap-3 top-info-left">
                <span class="d-inline-flex align-items-center text-maroon fw-semibold">
                    <span class="pulse-dot me-1"></span>
                    <i class="fas fa-clock me-1 text-muted"></i>
                    <span id="doha-clock"><?= date('h:i:s A') ?></span> <span class="badge bg-maroon-subtle text-maroon ms-1">AST</span>
                </span>
                <span class="text-muted d-none d-md-inline">
                    <i class="far fa-calendar-alt me-1"></i>
                    <span id="current-date"><?= date('l, d F Y') ?></span>
                </span>
                <span class="text-muted d-none d-lg-inline">
                    <i class="fas fa-sun text-warning me-1"></i>
                    Doha <?= $settings['doha_weather']['temp'] ?? '34°C' ?> &bull; <?= t($settings['doha_weather']['condition_en'] ?? 'Clear', $settings['doha_weather']['condition_ml'] ?? 'തെളിഞ്ഞത്') ?>
                </span>
            </div>

            <!-- Right Info: Currency snippet, Lang toggle, Theme switcher, Socials -->
            <div class="d-flex align-items-center gap-2 ms-auto top-info-right">
                <!-- Currency quick snippet -->
                <div class="d-none d-xl-flex align-items-center me-2 text-secondary font-monospace small">
                    <span class="badge bg-light text-dark border me-1">QAR</span>
                    <span>1 = <?= $settings['exchange_rates']['rates']['INR'] ?? 22.85 ?> INR</span>
                </div>

                <!-- Language Switcher -->
                <a href="<?= $langSwitchUrl ?>" class="btn btn-sm btn-outline-maroon px-2 py-0 fw-bold" title="Switch Language">
                    <i class="fas fa-language me-1"></i>
                    <?= $currentLang === 'ml' ? 'English' : 'മലയാളം' ?>
                </a>

                <!-- Dark Mode Toggle -->
                <button class="btn btn-sm btn-light border p-1 px-2" id="theme-toggle" title="Toggle Dark/Light Mode" aria-label="Toggle theme">
                    <i class="fas fa-moon" id="theme-icon"></i>
                </button>

                <!-- Facebook direct link -->
                <a href="<?= htmlspecialchars($settings['facebook_url']) ?>" target="_blank" rel="noopener" class="text-primary fs-6 ms-1" title="Follow News At Doha on Facebook">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="<?= htmlspecialchars($settings['whatsapp_channel'] ?? '#') ?>" target="_blank" rel="noopener" class="text-success fs-6 ms-1" title="Join WhatsApp Channel">
                    <i class="fab fa-whatsapp"></i>
                </a>
                <a href="<?= htmlspecialchars($settings['youtube_url'] ?? '#') ?>" target="_blank" rel="noopener" class="text-danger fs-6 ms-1" title="YouTube Channel">
                    <i class="fab fa-youtube"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Header & Branding Area -->
    <header class="main-header py-3 bg-white border-bottom shadow-xs">
        <div class="container d-flex flex-wrap justify-content-between align-items-center">
            <!-- Brand Logo & Titles -->
            <a href="<?= base_url() ?>" class="d-flex align-items-center text-decoration-none brand-container">
                <img src="<?= base_url('assets/img/logo.jpg') ?>" alt="News At Doha" class="brand-logo me-3 shadow-xs">
                <div>
                    <div class="brand-title">
                        <span class="brand-news">NEWS</span>
                        <span class="brand-at">@</span>
                        <span class="brand-doha">DOHA</span>
                    </div>
                    <div class="brand-tagline">
                        <?= t($settings['site_tagline_en'], $settings['site_tagline_ml']) ?>
                    </div>
                </div>
            </a>

            <!-- Header Right: Emergency & Community Badges -->
            <div class="d-none d-lg-flex align-items-center gap-3">
                <a href="tel:999" class="header-callout-box d-flex align-items-center text-decoration-none border rounded p-2 px-3 bg-light">
                    <div class="callout-icon me-2 text-danger fs-4">
                        <i class="fas fa-ambulance"></i>
                    </div>
                    <div>
                        <div class="callout-sub small text-muted"><?= t('Qatar Emergency', 'ഖത്തർ അത്യാഹിതം') ?></div>
                        <div class="callout-main fw-bold text-danger">Dial 999</div>
                    </div>
                </a>

                <a href="<?= htmlspecialchars($settings['facebook_url']) ?>" target="_blank" rel="noopener" class="header-callout-box d-flex align-items-center text-decoration-none border rounded p-2 px-3 bg-primary-subtle border-primary-subtle">
                    <div class="callout-icon me-2 text-primary fs-3">
                        <i class="fab fa-facebook"></i>
                    </div>
                    <div>
                        <div class="callout-sub small text-primary fw-bold"><?= $settings['facebook_likes'] ?? '12,200+' ?> Followers</div>
                        <div class="callout-main fw-bold text-dark"><?= t('Join Facebook Page', 'ഫേസ്ബുക്ക് പേജ്') ?></div>
                    </div>
                </a>
            </div>
        </div>
    </header>

    <!-- Main Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-maroon sticky-top shadow-sm py-1">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                <span class="ms-1 small"><?= t('Menu', 'മെനു') ?></span>
            </button>

            <!-- Mobile quick search & lang icon -->
            <div class="d-flex d-lg-none align-items-center gap-2">
                <a href="<?= $langSwitchUrl ?>" class="btn btn-sm btn-outline-light py-0 px-2">
                    <?= $currentLang === 'ml' ? 'ENG' : 'മലയാളം' ?>
                </a>
                <a href="<?= base_url('search.php') ?>" class="text-white px-2">
                    <i class="fas fa-search"></i>
                </a>
            </div>

            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?= ($activePage === 'index' && empty($currentCat)) ? 'active' : '' ?>" href="<?= base_url() ?>">
                            <i class="fas fa-home me-1"></i> <?= t('Home', 'ഹോം') ?>
                        </a>
                    </li>
                    <?php foreach ($categories as $cat): ?>
                    <li class="nav-item">
                        <a class="nav-link <?= ($currentCat === $cat['id']) ? 'active' : '' ?>" href="<?= base_url('category.php?cat=' . urlencode($cat['id'])) ?>">
                            <?= t($cat['name_en'], $cat['name_ml']) ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                    <li class="nav-item">
                        <a class="nav-link <?= ($activePage === 'expat-guide') ? 'active' : '' ?>" href="<?= base_url('expat-guide.php') ?>">
                            <i class="fas fa-passport me-1"></i> <?= t('Expat Guide', 'പ്രവാസി ഗൈഡ്') ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($activePage === 'currency') ? 'active' : '' ?>" href="<?= base_url('currency.php') ?>">
                            <i class="fas fa-exchange-alt me-1"></i> <?= t('QAR Rates', 'കറൻസി നിരക്ക്') ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($activePage === 'directory') ? 'active' : '' ?>" href="<?= base_url('directory.php') ?>">
                            <i class="fas fa-phone-alt me-1"></i> <?= t('Helplines', 'ഹെൽപ്പ്‌ലൈൻ') ?>
                        </a>
                    </li>
                </ul>

                <!-- Search form in navbar -->
                <form class="d-flex align-items-center ms-lg-2 my-2 my-lg-0" action="<?= base_url('search.php') ?>" method="GET">
                    <div class="input-group input-group-sm">
                        <input class="form-control nav-search-input" type="search" name="q" placeholder="<?= t('Search Qatar news...', 'വാർത്തകൾ തിരയുക...') ?>" aria-label="Search">
                        <button class="btn btn-gold text-dark" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>

                <!-- Admin Link -->
                <a href="<?= base_url('admin/index.php') ?>" class="btn btn-sm btn-outline-light ms-lg-2 d-none d-lg-inline-block" title="Editorial Admin Panel">
                    <i class="fas fa-lock me-1"></i> <?= t('Admin', 'അഡ്മിൻ') ?>
                </a>
            </div>
        </div>
    </nav>

    <!-- Breaking News Ticker Bar -->
    <?php if (!empty($breakingItems)): ?>
    <div class="breaking-ticker-bar border-bottom">
        <div class="container d-flex align-items-center">
            <div class="ticker-badge">
                <span class="badge bg-danger text-white text-uppercase pulse-fast">
                    <i class="fas fa-bolt me-1"></i> <?= t('Breaking News', 'ബ്രേക്കിംഗ് ന്യൂസ്') ?>
                </span>
            </div>
            <div class="ticker-content flex-grow-1 overflow-hidden ms-3">
                <div class="ticker-marquee">
                    <?php foreach ($breakingItems as $item): ?>
                        <span class="ticker-item me-4">
                            <?php if ($item['url']): ?>
                                <a href="<?= $item['url'] ?>" class="text-decoration-none text-dark fw-semibold ticker-link">
                                    &bull; <?= htmlspecialchars(t($item['en'], $item['ml'])) ?>
                                </a>
                            <?php else: ?>
                                <span class="fw-semibold text-dark">
                                    &bull; <?= htmlspecialchars(t($item['en'], $item['ml'])) ?>
                                </span>
                            <?php endif; ?>
                        </span>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
