<?php
// article.php - Single Article View for NEWS @ DOHA
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/widgets.php';

$settings = get_settings();
$articleId = $_GET['id'] ?? '';
$article = get_article_by_id($articleId);

if (!$article) {
    http_response_code(404);
    $pageTitle = t('Article Not Found', 'വാർത്ത കണ്ടെത്താനായില്ല');
    include __DIR__ . '/includes/header.php';
    ?>
    <main class="container my-5 text-center py-5">
        <div class="py-5">
            <i class="fas fa-exclamation-circle text-maroon fa-4x mb-3"></i>
            <h2 class="fw-bold mb-3"><?= t('Article Not Found', 'ക്ഷമിക്കുക, ഈ വാർത്ത കണ്ടെത്താനായില്ല') ?></h2>
            <p class="text-muted mb-4"><?= t('The requested article might have been moved or removed.', 'നിങ്ങൾ തിരഞ്ഞ വാർത്ത നിലവിൽ ലഭ്യമല്ല അല്ലെങ്കിൽ മാറ്റപ്പെട്ടിരിക്കാം.') ?></p>
            <a href="<?= base_url() ?>" class="btn btn-maroon px-4 py-2">
                <i class="fas fa-home me-1"></i> <?= t('Return to Homepage', 'ഹോംപേജിലേക്ക് മടങ്ങുക') ?>
            </a>
        </div>
    </main>
    <?php
    include __DIR__ . '/includes/footer.php';
    exit;
}

$catInfo = get_category_by_id($article['category']);
$pageTitle = t($article['title_en'], $article['title_ml']);
$pageDesc = t($article['summary_en'], $article['summary_ml']);
$pageImage = $article['image'];

// Related articles from same category
$relatedArticles = array_filter(get_articles($article['category'], null, 4), function($a) use ($article) {
    return $a['id'] !== $article['id'];
});
$relatedArticles = array_slice($relatedArticles, 0, 3);

include __DIR__ . '/includes/header.php';
?>

<main class="container my-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3 small">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="text-decoration-none text-muted"><i class="fas fa-home me-1"></i><?= t('Home', 'ഹോം') ?></a></li>
            <?php if ($catInfo): ?>
            <li class="breadcrumb-item">
                <a href="<?= base_url('category.php?cat=' . urlencode($catInfo['id'])) ?>" class="text-decoration-none text-maroon">
                    <?= t($catInfo['name_en'], $catInfo['name_ml']) ?>
                </a>
            </li>
            <?php endif; ?>
            <li class="breadcrumb-item active text-truncate" aria-current="page" style="max-width: 350px;">
                <?= htmlspecialchars(t($article['title_en'], $article['title_ml'])) ?>
            </li>
        </ol>
    </nav>

    <div class="row g-4">
        <!-- LEFT COLUMN: ARTICLE CONTENT (8 of 12) -->
        <div class="col-lg-8">
            <article class="bg-white p-4 p-md-5 rounded shadow-sm border mb-4">
                
                <!-- Category Badge & Status -->
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                    <div>
                        <?php if ($catInfo): ?>
                        <a href="<?= base_url('category.php?cat=' . urlencode($catInfo['id'])) ?>" class="badge bg-maroon text-decoration-none px-3 py-2 text-uppercase">
                            <?= t($catInfo['name_en'], $catInfo['name_ml']) ?>
                        </a>
                        <?php endif; ?>
                        <?php if (!empty($article['breaking'])): ?>
                        <span class="badge bg-danger ms-1 text-uppercase"><i class="fas fa-bolt me-1"></i> <?= t('Breaking', 'ബ്രേക്കിംഗ്') ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="text-muted small">
                        <i class="far fa-eye me-1"></i> <?= number_format($article['views'] ?? 1250) ?> <?= t('Reads', 'വായനകൾ') ?>
                    </div>
                </div>

                <!-- Main Headline -->
                <h1 class="article-main-title mb-3 text-dark">
                    <?= htmlspecialchars(t($article['title_en'], $article['title_ml'])) ?>
                </h1>

                <!-- Secondary title in other language -->
                <div class="alert alert-light border small text-muted mb-4 py-2">
                    <span class="fw-bold me-1"><?= $currentLang === 'ml' ? 'English:' : 'മലയാളത്തിൽ:' ?></span>
                    <span><?= htmlspecialchars($currentLang === 'ml' ? $article['title_en'] : $article['title_ml']) ?></span>
                </div>

                <!-- Metadata Row (Author, Date, Read Time) -->
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 py-2 border-top border-bottom mb-4 text-muted small">
                    <div class="d-flex align-items-center gap-3">
                        <span><i class="far fa-user me-1 text-maroon"></i> <strong><?= htmlspecialchars($article['author']) ?></strong></span>
                        <span><i class="far fa-calendar-alt me-1 text-maroon"></i> <?= date('d M Y, h:i A', strtotime($article['date'])) ?></span>
                        <span><i class="far fa-clock me-1 text-maroon"></i> <?= $article['read_time'] ?></span>
                    </div>
                    <div class="d-flex align-items-center gap-1">
                        <span class="me-1 fw-bold"><?= t('Font Size:', 'ഫോണ്ട്:') ?></span>
                        <button class="btn btn-sm btn-outline-secondary py-0 px-2" id="font-decrease" title="Decrease font">A-</button>
                        <button class="btn btn-sm btn-outline-secondary py-0 px-2" id="font-reset" title="Reset font">A</button>
                        <button class="btn btn-sm btn-outline-secondary py-0 px-2" id="font-increase" title="Increase font">A+</button>
                    </div>
                </div>

                <!-- Interactive Tool Bar (Social Share & Audio TTS) -->
                <div class="article-tool-bar d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <!-- Share Icons -->
                    <div class="d-flex align-items-center gap-2">
                        <span class="small fw-bold text-muted me-1"><?= t('Share:', 'പങ്കുവെക്കുക:') ?></span>
                        <?php
                        $articleUrl = urlencode((empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
                        $articleTitleEncoded = urlencode(t($article['title_en'], $article['title_ml']));
                        ?>
                        <a href="https://api.whatsapp.com/send?text=<?= $articleTitleEncoded ?>%20-%20<?= $articleUrl ?>" target="_blank" rel="noopener" class="share-btn share-wa" title="Share on WhatsApp">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $articleUrl ?>" target="_blank" rel="noopener" class="share-btn share-fb" title="Share on Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?text=<?= $articleTitleEncoded ?>&url=<?= $articleUrl ?>" target="_blank" rel="noopener" class="share-btn share-x" title="Share on X (Twitter)">
                            <i class="fab fa-x-twitter"></i>
                        </a>
                        <a href="https://t.me/share/url?url=<?= $articleUrl ?>&text=<?= $articleTitleEncoded ?>" target="_blank" rel="noopener" class="share-btn share-tg" title="Share on Telegram">
                            <i class="fab fa-telegram-plane"></i>
                        </a>
                        <button class="share-btn share-copy border-0" id="btn-copy-link" title="Copy article link">
                            <i class="fas fa-link"></i>
                        </button>
                    </div>

                    <!-- Audio Reader Simulation -->
                    <div>
                        <button class="btn btn-sm btn-outline-secondary" id="btn-listen-article">
                            <i class="fas fa-volume-up me-1 text-maroon"></i> <?= t('Listen to Article', 'വാർത്ത കേൾക്കുക') ?>
                        </button>
                    </div>
                </div>

                <!-- Featured Image -->
                <div class="article-featured-image mb-4 text-center">
                    <img src="<?= htmlspecialchars($article['image']) ?>" alt="<?= htmlspecialchars(t($article['title_en'], $article['title_ml'])) ?>" class="img-fluid rounded shadow-xs w-100" style="max-height: 480px; object-fit: cover;">
                    <div class="text-muted small mt-2 fst-italic">
                        <?= htmlspecialchars(t($article['summary_en'], $article['summary_ml'])) ?>
                    </div>
                </div>

                <!-- Article Body Content -->
                <div class="article-body" id="article-content-body">
                    <?= $currentLang === 'ml' ? $article['content_ml'] : $article['content_en'] ?>
                </div>

                <!-- Official Facebook Discussion Box -->
                <div class="p-4 rounded bg-light border border-primary border-opacity-50 mt-5">
                    <div class="d-flex align-items-center mb-2">
                        <i class="fab fa-facebook text-primary fs-3 me-2"></i>
                        <h5 class="fw-bold mb-0"><?= t('Join the Discussion on Facebook', 'ഫേസ്ബുക്കിൽ ചർച്ചയിൽ പങ്കുചേരുക') ?></h5>
                    </div>
                    <p class="small text-muted mb-3">
                        <?= t('What is your opinion on this news? Comment and engage with over 12,200+ Qatar residents on our official Facebook community page.',
                              'ഈ വാർത്തയെക്കുറിച്ചുള്ള നിങ്ങളുടെ അഭിപ്രായം എന്താണ്? ഞങ്ങളുടെ ഔദ്യോഗിക ഫേസ്ബുക്ക് പേജിൽ ചർച്ച ചെയ്യുക.') ?>
                    </p>
                    <a href="<?= htmlspecialchars($settings['facebook_url']) ?>" target="_blank" rel="noopener" class="btn btn-primary btn-sm">
                        <i class="fab fa-facebook me-1"></i> <?= t('Open News At Doha on Facebook', 'ഫേസ്ബുക്ക് പേജ് തുറക്കുക') ?> &rarr;
                    </a>
                </div>
            </article>

            <!-- RELATED ARTICLES -->
            <?php if (!empty($relatedArticles)): ?>
            <section class="related-section mb-4">
                <div class="section-header">
                    <h4 class="section-title fs-5">
                        <i class="fas fa-newspaper text-maroon"></i>
                        <?= t('Related Stories', 'ബന്ധപ്പെട്ട വാർത്തകൾ') ?>
                    </h4>
                </div>
                <div class="row g-3">
                    <?php foreach ($relatedArticles as $rel): ?>
                    <div class="col-md-4">
                        <div class="news-card h-100 d-flex flex-column">
                            <div class="news-card-img-wrap" style="height: 140px;">
                                <img src="<?= htmlspecialchars($rel['image']) ?>" alt="<?= htmlspecialchars(t($rel['title_en'], $rel['title_ml'])) ?>" loading="lazy">
                            </div>
                            <div class="p-3 d-flex flex-column flex-grow-1">
                                <small class="text-muted mb-1"><i class="far fa-clock me-1"></i><?= date('d M Y', strtotime($rel['date'])) ?></small>
                                <h6 class="fw-bold lh-sm mb-2">
                                    <a href="<?= base_url('article.php?id=' . urlencode($rel['id'])) ?>" class="text-decoration-none text-dark title-hover">
                                        <?= htmlspecialchars(t($rel['title_en'], $rel['title_ml'])) ?>
                                    </a>
                                </h6>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </section>
            <?php endif; ?>
        </div>

        <!-- RIGHT COLUMN: SIDEBAR (4 of 12) -->
        <div class="col-lg-4">
            <aside class="sidebar">
                <?php render_facebook_box($settings); ?>
                <?php render_currency_widget($settings); ?>
                <?php render_trending_articles(5); ?>
                <?php render_prayer_widget($settings); ?>
            </aside>
        </div>
    </div>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
