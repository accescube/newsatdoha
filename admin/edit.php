<?php
// admin/edit.php - Article Creator & Editor
require_once __DIR__ . '/auth.php';
check_admin_auth();

$categories = get_categories();
$articleId = $_GET['id'] ?? '';
$article = !empty($articleId) ? get_article_by_id($articleId) : null;
$isNew = empty($article);

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title_en = trim($_POST['title_en'] ?? '');
    $title_ml = trim($_POST['title_ml'] ?? '');
    $category = trim($_POST['category'] ?? 'qatar');
    $author = trim($_POST['author'] ?? 'News At Doha Editorial Desk');
    $date = trim($_POST['date'] ?? date('Y-m-d H:i'));
    $read_time = trim($_POST['read_time'] ?? '3 min read');
    $image = trim($_POST['image'] ?? '');
    $featured = !empty($_POST['featured']);
    $breaking = !empty($_POST['breaking']);
    $summary_en = trim($_POST['summary_en'] ?? '');
    $summary_ml = trim($_POST['summary_ml'] ?? '');
    $content_en = trim($_POST['content_en'] ?? '');
    $content_ml = trim($_POST['content_ml'] ?? '');

    if (empty($title_en)) {
        $error = 'Please provide an English headline for the article.';
    } else {
        $data = [
            'id' => $article['id'] ?? '',
            'category' => $category,
            'title_en' => $title_en,
            'title_ml' => $title_ml ?: $title_en,
            'author' => $author,
            'date' => $date,
            'read_time' => $read_time,
            'image' => $image ?: 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=1200&q=80',
            'featured' => $featured,
            'breaking' => $breaking,
            'views' => $article['views'] ?? rand(500, 2500),
            'summary_en' => $summary_en,
            'summary_ml' => $summary_ml ?: $summary_en,
            'content_en' => $content_en ?: "<p>$summary_en</p>",
            'content_ml' => $content_ml ?: "<p>$summary_ml</p>"
        ];

        save_article($data);
        header("Location: " . base_url('admin/index.php?msg=saved'));
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $isNew ? 'Create New Article' : 'Edit Article' ?> | NEWS @ DOHA Editorial</title>
    <link rel="icon" type="image/jpeg" href="<?= base_url('assets/img/logo.jpg') ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Inter', system-ui, sans-serif;
        }
        .bg-maroon {
            background-color: #8A1538;
        }
        .btn-maroon {
            background-color: #8A1538;
            color: #ffffff;
        }
        .btn-maroon:hover {
            background-color: #630c24;
            color: #ffffff;
        }
        .sidebar-admin {
            min-height: 100vh;
            background-color: #111418;
            color: #ffffff;
        }
        .sidebar-admin .nav-link {
            color: #9ca3af;
            padding: 0.75rem 1rem;
            border-radius: 6px;
            margin-bottom: 0.25rem;
        }
        .sidebar-admin .nav-link:hover, .sidebar-admin .nav-link.active {
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar-admin p-3 collapse">
                <div class="d-flex align-items-center mb-4 pb-3 border-bottom border-secondary">
                    <img src="<?= base_url('assets/img/logo.jpg') ?>" alt="News At Doha" class="rounded me-2" width="40" height="40">
                    <div>
                        <h6 class="mb-0 fw-bold text-white">NEWS @ DOHA</h6>
                        <small class="text-secondary">CMS v1.0</small>
                    </div>
                </div>

                <ul class="nav flex-column mb-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('admin/index.php') ?>">
                            <i class="fas fa-newspaper me-2"></i> All Articles
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="<?= base_url('admin/edit.php') ?>">
                            <i class="fas fa-plus-circle me-2"></i> New Article
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('admin/settings.php') ?>">
                            <i class="fas fa-cog me-2"></i> Site Settings & Rates
                        </a>
                    </li>
                    <li class="nav-item mt-3 pt-3 border-top border-secondary">
                        <a class="nav-link text-info" href="<?= base_url() ?>" target="_blank">
                            <i class="fas fa-external-link-alt me-2"></i> Live Website
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="<?= base_url('admin/logout.php') ?>">
                            <i class="fas fa-sign-out-alt me-2"></i> Log Out
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2 pb-3 mb-4 border-bottom">
                    <div>
                        <h1 class="h3 fw-bold text-dark mb-1">
                            <?= $isNew ? 'Create New Article' : 'Edit Article' ?>
                        </h1>
                        <p class="text-muted small mb-0">Publish bilingual news reports and guides for the Qatar community.</p>
                    </div>
                    <div>
                        <a href="<?= base_url('admin/index.php') ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
                        </a>
                    </div>
                </div>

                <?php if ($error): ?>
                <div class="alert alert-danger py-2">
                    <i class="fas fa-exclamation-triangle me-1"></i> <?= htmlspecialchars($error) ?>
                </div>
                <?php endif; ?>

                <form action="" method="POST" class="card border-0 shadow-sm p-4">
                    <div class="row g-3">
                        <!-- English Title -->
                        <div class="col-12">
                            <label class="form-label fw-bold">Headline (English) <span class="text-danger">*</span></label>
                            <input type="text" name="title_en" class="form-control form-control-lg" value="<?= htmlspecialchars($article['title_en'] ?? '') ?>" placeholder="Enter English headline" required>
                        </div>

                        <!-- Malayalam Title -->
                        <div class="col-12">
                            <label class="form-label fw-bold">വാർത്താ തലക്കെട്ട് (മലയാളം)</label>
                            <input type="text" name="title_ml" class="form-control" value="<?= htmlspecialchars($article['title_ml'] ?? '') ?>" placeholder="മലയാളം തലക്കെട്ട് നൽകുക">
                        </div>

                        <!-- Category & Author -->
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Category</label>
                            <select name="category" class="form-select">
                                <?php foreach ($categories as $c): ?>
                                <option value="<?= $c['id'] ?>" <?= ($article['category'] ?? '') === $c['id'] ? 'selected' : '' ?>>
                                    <?= $c['name_en'] ?> (<?= $c['name_ml'] ?>)
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold">Author / Desk</label>
                            <input type="text" name="author" class="form-control" value="<?= htmlspecialchars($article['author'] ?? 'News At Doha Editorial Desk') ?>">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold">Publish Date & Time</label>
                            <input type="text" name="date" class="form-control" value="<?= htmlspecialchars($article['date'] ?? date('Y-m-d H:i')) ?>">
                        </div>

                        <!-- Image URL & Reading Time -->
                        <div class="col-md-8">
                            <label class="form-label fw-bold">Featured Image URL</label>
                            <input type="url" name="image" id="img-url-input" class="form-control" value="<?= htmlspecialchars($article['image'] ?? 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=1200&q=80') ?>" placeholder="https://...">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold">Estimated Read Time</label>
                            <input type="text" name="read_time" class="form-control" value="<?= htmlspecialchars($article['read_time'] ?? '3 min read') ?>">
                        </div>

                        <!-- Status Checkboxes -->
                        <div class="col-12">
                            <div class="d-flex gap-4 p-3 bg-light rounded border">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="featured" id="featuredCheck" <?= !empty($article['featured']) ? 'checked' : '' ?>>
                                    <label class="form-check-label fw-bold" for="featuredCheck">
                                        <i class="fas fa-star text-warning me-1"></i> Featured on Homepage Hero
                                    </label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="breaking" id="breakingCheck" <?= !empty($article['breaking']) ? 'checked' : '' ?>>
                                    <label class="form-check-label fw-bold" for="breakingCheck">
                                        <i class="fas fa-bolt text-danger me-1"></i> Mark as Breaking News Ticker
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Summaries -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Summary / Excerpt (English)</label>
                            <textarea name="summary_en" class="form-control" rows="3" placeholder="Brief summary for list cards..."><?= htmlspecialchars($article['summary_en'] ?? '') ?></textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">സംഗ്രഹം (മലയാളം)</label>
                            <textarea name="summary_ml" class="form-control" rows="3" placeholder="വാർത്തയുടെ ചുരുക്കം..."><?= htmlspecialchars($article['summary_ml'] ?? '') ?></textarea>
                        </div>

                        <!-- Full Content -->
                        <div class="col-12">
                            <label class="form-label fw-bold">Full Article Content (English - HTML supported)</label>
                            <textarea name="content_en" class="form-control font-monospace" rows="8" placeholder="<p>Article body paragraphs...</p>"><?= htmlspecialchars($article['content_en'] ?? '') ?></textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold">പൂർണ്ണ വാർത്ത (മലയാളം - HTML supported)</label>
                            <textarea name="content_ml" class="form-control font-monospace" rows="8" placeholder="<p>വാർത്താ വിവരങ്ങൾ...</p>"><?= htmlspecialchars($article['content_ml'] ?? '') ?></textarea>
                        </div>

                        <div class="col-12 mt-4 text-end">
                            <a href="<?= base_url('admin/index.php') ?>" class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-maroon px-4 py-2 fw-bold">
                                <i class="fas fa-save me-1"></i> <?= $isNew ? 'Publish Article' : 'Save Changes' ?>
                            </button>
                        </div>
                    </div>
                </form>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
