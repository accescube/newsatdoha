<?php
// search.php - Search page for NEWS @ DOHA
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/widgets.php';

$settings = get_settings();
$query = trim($_GET['q'] ?? '');
$results = !empty($query) ? search_articles($query) : [];

$pageTitle = !empty($query) ? t("Search: $query", "തിരച്ചിൽ: $query") : t('Search Qatar News', 'വാർത്തകൾ തിരയുക');
include __DIR__ . '/includes/header.php';
?>

<main class="container my-4">
    <!-- Search Box Header -->
    <div class="bg-white p-4 p-md-5 rounded shadow-sm border mb-4">
        <h2 class="fw-bold mb-3 text-maroon">
            <i class="fas fa-search me-2"></i><?= t('Search News At Doha', 'ഖത്തർ വാർത്തകൾ തിരയുക') ?>
        </h2>
        <form action="<?= base_url('search.php') ?>" method="GET" class="row g-2">
            <div class="col-md-9">
                <input type="text" name="q" class="form-control form-control-lg" placeholder="<?= t('Type keywords e.g. Metrash, Visa, Ashghal, Gold, Jobs...', 'കീവേർഡുകൾ ടൈപ്പ് ചെയ്യുക: വിസ, മെട്രാഷ്, സ്വർണ്ണം, ജോലി...') ?>" value="<?= htmlspecialchars($query) ?>" required autofocus>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-maroon btn-lg w-100 fw-bold">
                    <i class="fas fa-search me-1"></i> <?= t('Search', 'തിരയുക') ?>
                </button>
            </div>
        </form>

        <?php if (!empty($query)): ?>
        <div class="mt-3 text-muted small">
            <?= t('Found', 'കണ്ടെത്തിയത്:') ?> <strong class="text-maroon"><?= count($results) ?></strong> <?= t("results for \"$query\"", "\"$query\" എന്നതിനുള്ള ഫലങ്ങൾ") ?>
        </div>
        <?php endif; ?>
    </div>

    <div class="row g-4">
        <!-- LEFT: SEARCH RESULTS (8 of 12) -->
        <div class="col-lg-8">
            <?php if (!empty($query) && empty($results)): ?>
                <div class="text-center py-5 bg-white rounded border">
                    <i class="fas fa-search fa-3x text-muted mb-3"></i>
                    <h4><?= t('No matching articles found', 'വാർത്തകളൊന്നും കണ്ടെത്താനായില്ല') ?></h4>
                    <p class="text-muted"><?= t('Try searching with different or broader keywords like "visa", "Qatar", "gold", or "jobs".', 'ദയവായി മറ്റ് പദങ്ങൾ ഉപയോഗിച്ച് വീണ്ടും തിരയുക.') ?></p>
                </div>
            <?php elseif (!empty($results)): ?>
                <div class="row g-3">
                    <?php foreach ($results as $art): ?>
                    <div class="col-12">
                        <div class="news-card p-3 d-flex flex-column flex-md-row gap-3">
                            <div class="rounded overflow-hidden flex-shrink-0" style="width: 180px; height: 120px;">
                                <img src="<?= htmlspecialchars($art['image']) ?>" alt="<?= htmlspecialchars(t($art['title_en'], $art['title_ml'])) ?>" class="w-100 h-100 object-fit-cover">
                            </div>
                            <div class="flex-grow-1">
                                <div class="mb-1">
                                    <span class="badge bg-maroon me-2"><?= ucfirst($art['category']) ?></span>
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
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="bg-white p-4 rounded border text-center text-muted">
                    <p class="mb-0"><?= t('Enter a search query above to browse articles, guides, and community announcements.', 'വാർത്തകളും അറിയിപ്പുകളും തിരയാൻ മുകളിൽ സെർച്ച് ചെയ്യുക.') ?></p>
                </div>
            <?php endif; ?>
        </div>

        <!-- RIGHT: SIDEBAR (4 of 12) -->
        <div class="col-lg-4">
            <aside class="sidebar">
                <?php render_trending_articles(5); ?>
                <?php render_currency_widget($settings); ?>
            </aside>
        </div>
    </div>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
