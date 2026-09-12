<?php
// index.php - Homepage for NEWS @ DOHA
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/widgets.php';

$settings = get_settings();
$featuredArticles = get_articles(null, true, 5);
$mainHero = $featuredArticles[0] ?? null;
$subHeroes = array_slice($featuredArticles, 1, 2);

$qatarNews = get_articles('qatar', null, 4);
$expatNews = get_articles('expat', null, 4);
$businessNews = get_articles('business', null, 3);
$communityNews = get_articles('community', null, 3);
$sportsNews = get_articles('sports', null, 3);
$jobsNews = get_articles('jobs', null, 3);

$pageTitle = t('Latest Qatar News, Expat Updates & Community Hub', 'ഖത്തറിലെ പ്രധാന വാർത്തകൾ, പ്രവാസി അറിയിപ്പുകൾ');
include __DIR__ . '/includes/header.php';
?>

<main class="container my-4">
    <!-- HERO EDITORIAL GRID -->
    <?php if ($mainHero): ?>
    <section class="hero-section mb-5">
        <div class="row g-3">
            <!-- Main Hero Lead Story -->
            <div class="col-lg-8">
                <a href="<?= base_url('article.php?id=' . urlencode($mainHero['id'])) ?>" class="text-decoration-none">
                    <div class="hero-main-card">
                        <img src="<?= htmlspecialchars($mainHero['image']) ?>" alt="<?= htmlspecialchars(t($mainHero['title_en'], $mainHero['title_ml'])) ?>">
                        <div class="hero-overlay">
                            <div class="mb-2">
                                <span class="badge bg-danger text-uppercase px-2 py-1"><i class="fas fa-bolt me-1"></i> <?= t('Top Story', 'പ്രധാന വാർത്ത') ?></span>
                                <span class="badge bg-gold text-dark text-uppercase px-2 py-1 ms-1"><?= ucfirst($mainHero['category']) ?></span>
                            </div>
                            <h2 class="hero-title"><?= htmlspecialchars(t($mainHero['title_en'], $mainHero['title_ml'])) ?></h2>
                            <p class="text-white-50 d-none d-md-block mb-3 small">
                                <?= htmlspecialchars(t($mainHero['summary_en'], $mainHero['summary_ml'])) ?>
                            </p>
                            <div class="d-flex align-items-center text-white-50 small">
                                <span class="me-3"><i class="far fa-user me-1 text-gold"></i> <?= htmlspecialchars($mainHero['author']) ?></span>
                                <span class="me-3"><i class="far fa-clock me-1 text-gold"></i> <?= date('d M Y, h:i A', strtotime($mainHero['date'])) ?></span>
                                <span><i class="far fa-bookmark me-1 text-gold"></i> <?= $mainHero['read_time'] ?></span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Sub Hero Stories -->
            <div class="col-lg-4 d-flex flex-column gap-3">
                <?php foreach ($subHeroes as $subArt): ?>
                <a href="<?= base_url('article.php?id=' . urlencode($subArt['id'])) ?>" class="text-decoration-none flex-grow-1">
                    <div class="hero-subcard">
                        <img src="<?= htmlspecialchars($subArt['image']) ?>" alt="<?= htmlspecialchars(t($subArt['title_en'], $subArt['title_ml'])) ?>">
                        <div class="overlay">
                            <div class="mb-1">
                                <span class="badge bg-maroon text-uppercase px-2 py-1 small"><?= ucfirst($subArt['category']) ?></span>
                            </div>
                            <h3 class="title mb-2"><?= htmlspecialchars(t($subArt['title_en'], $subArt['title_ml'])) ?></h3>
                            <div class="small text-white-50">
                                <i class="far fa-clock me-1"></i> <?= date('d M Y', strtotime($subArt['date'])) ?>
                            </div>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- EXPAT GUIDE SPOTLIGHT BANNER -->
    <section class="expat-spotlight-banner mb-5 shadow-sm">
        <div class="row align-items-center">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <span class="badge bg-gold text-dark mb-2 text-uppercase fw-bold"><i class="fas fa-star me-1"></i> <?= t('Expatriate Essential', 'പ്രവാസി സ്പെഷ്യൽ') ?></span>
                <h3 class="fw-bold mb-2 text-white">
                    <?= t('Living in Qatar: Complete Expat Rights & Procedures Guide', 'ഖത്തറിൽ ജീവിക്കുന്ന പ്രവാസികൾ അറിയേണ്ട സുപ്രധാന നിയമങ്ങൾ') ?>
                </h3>
                <p class="text-white-50 mb-0">
                    <?= t('Comprehensive step-by-step guidance on Metrash2 residence permits, Qatar Labour Law gratuity formulas, driving license procedures, and Hamad health card applications.',
                          'മെട്രാഷ്2 സേവനങ്ങൾ, റെസിഡൻസ് പെർമിറ്റ് പുതുക്കൽ, സർവീസ് ആനുകൂല്യങ്ങൾ (ഗ്രാറ്റുവിറ്റി), തൊഴിൽ മാറ്റം, ഹമദ് ഹെൽത്ത് കാർഡ് എന്നിവ സംബന്ധിച്ച സമഗ്ര വിവരങ്ങൾ.') ?>
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="<?= base_url('expat-guide.php') ?>" class="btn btn-gold btn-lg shadow-sm">
                    <i class="fas fa-book-open me-1"></i> <?= t('Access Expat Guide', 'ഗൈഡ് വായിക്കുക') ?> &rarr;
                </a>
            </div>
        </div>
    </section>

    <!-- MAIN TWO-COLUMN CONTENT AREA -->
    <div class="row g-4">
        <!-- LEFT COLUMN: CATEGORIZED NEWS SECTIONS (8 of 12) -->
        <div class="col-lg-8">
            
            <!-- SECTION 1: QATAR & DOHA NEWS -->
            <section class="mb-5">
                <div class="section-header">
                    <h3 class="section-title">
                        <i class="fas fa-landmark text-maroon"></i>
                        <?= t('Qatar & Doha News', 'ഖത്തർ വാർത്തകൾ') ?>
                    </h3>
                    <a href="<?= base_url('category.php?cat=qatar') ?>" class="text-maroon text-decoration-none small fw-bold">
                        <?= t('View All', 'മുഴുവൻ വാർത്തകൾ') ?> &rarr;
                    </a>
                </div>

                <div class="row g-3">
                    <?php foreach ($qatarNews as $art): ?>
                    <div class="col-md-6">
                        <div class="news-card h-100 d-flex flex-column">
                            <div class="news-card-img-wrap">
                                <span class="badge bg-maroon category-badge-overlay"><?= t('Qatar', 'ഖത്തർ') ?></span>
                                <img src="<?= htmlspecialchars($art['image']) ?>" alt="<?= htmlspecialchars(t($art['title_en'], $art['title_ml'])) ?>" loading="lazy">
                            </div>
                            <div class="p-3 d-flex flex-column flex-grow-1">
                                <div class="text-muted small mb-2">
                                    <i class="far fa-clock me-1"></i> <?= date('d M Y', strtotime($art['date'])) ?>
                                    &bull; <span><?= $art['read_time'] ?></span>
                                </div>
                                <h5 class="fw-bold lh-sm mb-2">
                                    <a href="<?= base_url('article.php?id=' . urlencode($art['id'])) ?>" class="text-decoration-none text-dark title-hover">
                                        <?= htmlspecialchars(t($art['title_en'], $art['title_ml'])) ?>
                                    </a>
                                </h5>
                                <p class="text-muted small flex-grow-1">
                                    <?= htmlspecialchars(t($art['summary_en'], $art['summary_ml'])) ?>
                                </p>
                                <div class="pt-2 border-top mt-auto">
                                    <a href="<?= base_url('article.php?id=' . urlencode($art['id'])) ?>" class="text-maroon text-decoration-none fw-bold small">
                                        <?= t('Read Full Story', 'കൂടുതൽ വായിക്കുക') ?> &rarr;
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </section>

            <!-- SECTION 2: EXPAT AFFAIRS & VISAS -->
            <section class="mb-5">
                <div class="section-header">
                    <h3 class="section-title">
                        <i class="fas fa-id-card text-primary"></i>
                        <?= t('Visa & Expat Affairs', 'പ്രവാസി & വിസ വാർത്തകൾ') ?>
                    </h3>
                    <a href="<?= base_url('category.php?cat=expat') ?>" class="text-maroon text-decoration-none small fw-bold">
                        <?= t('View All', 'മുഴുവൻ വാർത്തകൾ') ?> &rarr;
                    </a>
                </div>

                <div class="row g-3">
                    <?php foreach ($expatNews as $art): ?>
                    <div class="col-md-6">
                        <div class="news-card h-100 d-flex flex-column">
                            <div class="news-card-img-wrap">
                                <span class="badge bg-primary category-badge-overlay"><?= t('Expat Guide', 'പ്രവാസി') ?></span>
                                <img src="<?= htmlspecialchars($art['image']) ?>" alt="<?= htmlspecialchars(t($art['title_en'], $art['title_ml'])) ?>" loading="lazy">
                            </div>
                            <div class="p-3 d-flex flex-column flex-grow-1">
                                <div class="text-muted small mb-2">
                                    <i class="far fa-clock me-1"></i> <?= date('d M Y', strtotime($art['date'])) ?>
                                </div>
                                <h5 class="fw-bold lh-sm mb-2">
                                    <a href="<?= base_url('article.php?id=' . urlencode($art['id'])) ?>" class="text-decoration-none text-dark title-hover">
                                        <?= htmlspecialchars(t($art['title_en'], $art['title_ml'])) ?>
                                    </a>
                                </h5>
                                <p class="text-muted small flex-grow-1">
                                    <?= htmlspecialchars(t($art['summary_en'], $art['summary_ml'])) ?>
                                </p>
                                <div class="pt-2 border-top mt-auto">
                                    <a href="<?= base_url('article.php?id=' . urlencode($art['id'])) ?>" class="text-maroon text-decoration-none fw-bold small">
                                        <?= t('Read Guide', 'വിശദാംശങ്ങൾ') ?> &rarr;
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </section>

            <!-- SECTION 3: BUSINESS, GOLD & JOBS IN DOHA -->
            <section class="mb-5">
                <div class="section-header">
                    <h3 class="section-title">
                        <i class="fas fa-briefcase text-success"></i>
                        <?= t('Jobs & Career Opportunities in Qatar', 'ഖത്തർ തൊഴിലവസരങ്ങൾ') ?>
                    </h3>
                    <a href="<?= base_url('category.php?cat=jobs') ?>" class="text-maroon text-decoration-none small fw-bold">
                        <?= t('View All Jobs', 'എല്ലാ ഒഴിവുകളും') ?> &rarr;
                    </a>
                </div>

                <div class="row g-3">
                    <?php foreach ($jobsNews as $art): ?>
                    <div class="col-12">
                        <div class="news-card p-3 d-flex flex-column flex-md-row gap-3 align-items-md-center">
                            <div class="rounded overflow-hidden flex-shrink-0" style="width: 140px; height: 100px;">
                                <img src="<?= htmlspecialchars($art['image']) ?>" alt="<?= htmlspecialchars(t($art['title_en'], $art['title_ml'])) ?>" class="w-100 h-100 object-fit-cover">
                            </div>
                            <div class="flex-grow-1">
                                <div class="mb-1">
                                    <span class="badge bg-success-subtle text-success border border-success me-2">
                                        <i class="fas fa-check-circle me-1"></i><?= t('Active Recruitment', 'റിക്രൂട്ട്മെന്റ്') ?>
                                    </span>
                                    <small class="text-muted"><i class="far fa-calendar me-1"></i><?= date('d M Y', strtotime($art['date'])) ?></small>
                                </div>
                                <h5 class="fw-bold mb-1">
                                    <a href="<?= base_url('article.php?id=' . urlencode($art['id'])) ?>" class="text-decoration-none text-dark title-hover">
                                        <?= htmlspecialchars(t($art['title_en'], $art['title_ml'])) ?>
                                    </a>
                                </h5>
                                <p class="text-muted small mb-0">
                                    <?= htmlspecialchars(t($art['summary_en'], $art['summary_ml'])) ?>
                                </p>
                            </div>
                            <div class="flex-shrink-0">
                                <a href="<?= base_url('article.php?id=' . urlencode($art['id'])) ?>" class="btn btn-sm btn-outline-maroon">
                                    <?= t('Apply / Details', 'വിവരങ്ങൾ') ?> &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </section>

            <!-- SECTION 4: COMMUNITY, CULTURE & SPORTS -->
            <section class="mb-4">
                <div class="row g-4">
                    <!-- Community Sub-column -->
                    <div class="col-md-6">
                        <div class="section-header">
                            <h4 class="section-title fs-5">
                                <i class="fas fa-users text-warning"></i>
                                <?= t('Community & Events', 'പ്രവാസി കൂട്ടായ്മ') ?>
                            </h4>
                        </div>
                        <?php foreach ($communityNews as $art): ?>
                        <div class="mb-3 pb-3 border-bottom">
                            <small class="text-muted"><i class="far fa-clock me-1"></i><?= date('d M Y', strtotime($art['date'])) ?></small>
                            <h6 class="fw-bold mt-1 mb-1">
                                <a href="<?= base_url('article.php?id=' . urlencode($art['id'])) ?>" class="text-decoration-none text-dark title-hover">
                                    <?= htmlspecialchars(t($art['title_en'], $art['title_ml'])) ?>
                                </a>
                            </h6>
                            <p class="small text-muted mb-0">
                                <?= mb_strimwidth(htmlspecialchars(t($art['summary_en'], $art['summary_ml'])), 0, 110, '...') ?>
                            </p>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Sports Sub-column -->
                    <div class="col-md-6">
                        <div class="section-header">
                            <h4 class="section-title fs-5">
                                <i class="fas fa-trophy text-danger"></i>
                                <?= t('Sports & Leisure', 'കായിക വാർത്തകൾ') ?>
                            </h4>
                        </div>
                        <?php foreach ($sportsNews as $art): ?>
                        <div class="mb-3 pb-3 border-bottom">
                            <small class="text-muted"><i class="far fa-clock me-1"></i><?= date('d M Y', strtotime($art['date'])) ?></small>
                            <h6 class="fw-bold mt-1 mb-1">
                                <a href="<?= base_url('article.php?id=' . urlencode($art['id'])) ?>" class="text-decoration-none text-dark title-hover">
                                    <?= htmlspecialchars(t($art['title_en'], $art['title_ml'])) ?>
                                </a>
                            </h6>
                            <p class="small text-muted mb-0">
                                <?= mb_strimwidth(htmlspecialchars(t($art['summary_en'], $art['summary_ml'])), 0, 110, '...') ?>
                            </p>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
        </div>

        <!-- RIGHT COLUMN: SIDEBAR SUITE (4 of 12) -->
        <div class="col-lg-4">
            <aside class="sidebar">
                <!-- 1. Official Facebook Page Card -->
                <?php render_facebook_box($settings); ?>

                <!-- 2. QAR Live Currency Exchange Calculator -->
                <?php render_currency_widget($settings); ?>

                <!-- 3. Doha Gold & Petrol Rates -->
                <?php render_gold_petrol_widget($settings); ?>

                <!-- 4. Trending in Qatar -->
                <?php render_trending_articles(5); ?>

                <!-- 5. Doha Prayer Times -->
                <?php render_prayer_widget($settings); ?>

                <!-- 6. Emergency & Hotlines -->
                <?php render_emergency_widget($settings); ?>
            </aside>
        </div>
    </div>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
