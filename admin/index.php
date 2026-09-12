<?php
// admin/index.php - Editorial CMS Dashboard
require_once __DIR__ . '/auth.php';
check_admin_auth();

$settings = get_settings();
$categories = get_categories();
$articles = get_articles();
$subscribers = get_json_data('subscribers.json');

// Handle deletion
$msg = '';
if (isset($_GET['action']) && $_GET['action'] === 'delete' && !empty($_GET['id'])) {
    delete_article($_GET['id']);
    header("Location: " . base_url('admin/index.php?msg=deleted'));
    exit;
}

if (isset($_GET['msg']) && $_GET['msg'] === 'deleted') {
    $msg = 'Article deleted successfully.';
} elseif (isset($_GET['msg']) && $_GET['msg'] === 'saved') {
    $msg = 'Article saved successfully.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | NEWS @ DOHA Editorial</title>
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
        .text-maroon {
            color: #8A1538;
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
                        <a class="nav-link active" href="<?= base_url('admin/index.php') ?>">
                            <i class="fas fa-newspaper me-2"></i> All Articles
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('admin/edit.php') ?>">
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
                        <h1 class="h3 fw-bold text-dark mb-1">Editorial Dashboard</h1>
                        <p class="text-muted small mb-0">Manage news stories, community alerts, and expat guides for News At Doha.</p>
                    </div>
                    <div class="btn-toolbar mb-2 mb-md-0 gap-2">
                        <a href="<?= base_url('admin/edit.php') ?>" class="btn btn-maroon">
                            <i class="fas fa-plus me-1"></i> Add New Article
                        </a>
                        <a href="<?= base_url() ?>" target="_blank" class="btn btn-outline-secondary">
                            <i class="fas fa-eye me-1"></i> View Website
                        </a>
                    </div>
                </div>

                <?php if ($msg): ?>
                <div class="alert alert-success alert-dismissible fade show py-2" role="alert">
                    <i class="fas fa-check-circle me-1"></i> <?= htmlspecialchars($msg) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>

                <!-- Stats Cards -->
                <div class="row g-3 mb-4">
                    <div class="col-sm-6 col-xl-3">
                        <div class="card border-0 shadow-sm p-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary-subtle text-primary p-3 rounded-circle me-3">
                                    <i class="fas fa-newspaper fa-lg"></i>
                                </div>
                                <div>
                                    <h6 class="text-muted small mb-1">Published Articles</h6>
                                    <h3 class="fw-bold mb-0"><?= count($articles) ?></h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-xl-3">
                        <div class="card border-0 shadow-sm p-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-danger-subtle text-danger p-3 rounded-circle me-3">
                                    <i class="fas fa-bolt fa-lg"></i>
                                </div>
                                <div>
                                    <h6 class="text-muted small mb-1">Breaking News</h6>
                                    <h3 class="fw-bold mb-0">
                                        <?= count(array_filter($articles, fn($a) => !empty($a['breaking']))) ?>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-xl-3">
                        <div class="card border-0 shadow-sm p-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-success-subtle text-success p-3 rounded-circle me-3">
                                    <i class="fas fa-users fa-lg"></i>
                                </div>
                                <div>
                                    <h6 class="text-muted small mb-1">Subscribers</h6>
                                    <h3 class="fw-bold mb-0"><?= count($subscribers) ?></h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-xl-3">
                        <div class="card border-0 shadow-sm p-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-warning-subtle text-warning-emphasis p-3 rounded-circle me-3">
                                    <i class="fab fa-facebook fa-lg"></i>
                                </div>
                                <div>
                                    <h6 class="text-muted small mb-1">FB Followers</h6>
                                    <h3 class="fw-bold mb-0"><?= $settings['facebook_likes'] ?? '12,213' ?></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Articles Table -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0"><i class="fas fa-list me-2 text-maroon"></i>All Articles</h5>
                        <span class="badge bg-light text-dark border"><?= count($articles) ?> records</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light small text-uppercase">
                                    <tr>
                                        <th style="width: 70px;">Image</th>
                                        <th>Headline & Details</th>
                                        <th>Category</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($articles as $art): ?>
                                    <tr>
                                        <td>
                                            <img src="<?= htmlspecialchars($art['image']) ?>" alt="" class="rounded" width="60" height="42" style="object-fit: cover;">
                                        </td>
                                        <td>
                                            <div class="fw-bold text-dark mb-1">
                                                <?= htmlspecialchars($art['title_en']) ?>
                                            </div>
                                            <div class="text-muted small" style="font-size: 0.82rem;">
                                                <span class="text-primary me-1">ML:</span> <?= htmlspecialchars($art['title_ml']) ?>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary"><?= ucfirst($art['category']) ?></span>
                                        </td>
                                        <td>
                                            <?php if (!empty($art['featured'])): ?>
                                                <span class="badge bg-warning text-dark me-1">Featured</span>
                                            <?php endif; ?>
                                            <?php if (!empty($art['breaking'])): ?>
                                                <span class="badge bg-danger">Breaking</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="small text-muted text-nowrap">
                                            <?= date('d M Y', strtotime($art['date'])) ?>
                                        </td>
                                        <td class="text-end text-nowrap">
                                            <a href="<?= base_url('article.php?id=' . urlencode($art['id'])) ?>" target="_blank" class="btn btn-sm btn-outline-secondary" title="View Article">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?= base_url('admin/edit.php?id=' . urlencode($art['id'])) ?>" class="btn btn-sm btn-outline-primary" title="Edit Article">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <a href="<?= base_url('admin/index.php?action=delete&id=' . urlencode($art['id'])) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this article?');" title="Delete Article">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
