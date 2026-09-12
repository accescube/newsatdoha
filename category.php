<?php
// category.php - Category Archive for NEWS @ DOHA
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/widgets.php';

$settings = get_settings();
$catId = $_GET['cat'] ?? '';
$category = get_category_by_id($catId);

if (!$category) {
    header("Location: " . base_url());
    exit;
}

$articles = get_articles($category['id']);
$pageTitle = t($category['name_en'], $category['name_ml']);
$pageDesc = t($category['description_en'], $category['description_ml']);

include __DIR__ . '/includes/header.php';
?>

<main class="container my-4">
    <!-- Category Hero Header -->
    <div class="p-4 p-md-5 rounded shadow-sm mb-4 text-white" style="background: linear-gradient(135deg, <?= $category['badge_color'] ?> 0%, #20050d 100%);">
        <div class="row align-items-center">
            <div class="col-md-8">
                <span class="badge bg-gold text-dark mb-2 text-uppercase fw-bold">
                    <i class="fas <?= $category['icon'] ?> me-1"></i> <?= t('Category Archive', 'വിഭാഗം') ?>
                </span>
                <h1 class="display-6 fw-bold mb-2">
                    <?= htmlspecialchars(t($category['name_en'], $category['name_ml'])) ?>
                </h1>
                <p class="lead fs-6 text-white-50 mb-0">
                    <?= htmlspecialchars(t($category['description_en'], $category['description_ml'])) ?>
                </p>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <span class="badge bg-white text-dark fs-6 px-3 py-2">
                    <i class="fas fa-newspaper me-1 text-maroon"></i> <?= count($articles) ?> <?= t('Articles', 'വാർത്തകൾ') ?>
                </span>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- LEFT COLUMN: ARTICLE LIST (8 of 12) -->
        <div class="col-lg-8">
            <?php if (empty($articles)): ?>
                <div class="text-center py-5 bg-white rounded border">
                    <i class="far fa-folder-open fa-3x text-muted mb-3"></i>
                    <h4><?= t('No articles in this category yet', 'ഈ വിഭാഗത്തിൽ നിലവിൽ വാർത്തകൾ ലഭ്യമല്ല') ?></h4>
                    <p class="text-muted"><?= t('Please check back soon for fresh updates.', 'പുതിയ വാർത്തകൾക്കായി ഉടൻ സന്ദർശിക്കുക.') ?></p>
                </div>
            <?php else: ?>
                <div class="row g-4">
                    <?php foreach ($articles as $art): ?>
                    <div class="col-md-6">
                        <div class="news-card h-100 d-flex flex-column">
                            <div class="news-card-img-wrap">
                                <span class="badge bg-maroon category-badge-overlay"><?= t($category['name_en'], $category['name_ml']) ?></span>
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
            <?php endif; ?>
        </div>

        <!-- RIGHT COLUMN: SIDEBAR (4 of 12) -->
        <div class="col-lg-4">
            <aside class="sidebar">
                <?php render_facebook_box($settings); ?>
                <?php render_currency_widget($settings); ?>
                <?php render_trending_articles(5); ?>
            </aside>
        </div>
    </div>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
