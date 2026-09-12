<?php
// includes/db.php - Data management and utilities for NEWS @ DOHA

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('DATA_PATH', dirname(__DIR__) . '/data');

// Language selection handler (stored in session or cookie)
if (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'ml'])) {
    $_SESSION['lang'] = $_GET['lang'];
    setcookie('site_lang', $_GET['lang'], time() + (86400 * 30), "/");
}

function get_current_lang() {
    if (isset($_SESSION['lang'])) {
        return $_SESSION['lang'];
    }
    if (isset($_COOKIE['site_lang']) && in_array($_COOKIE['site_lang'], ['en', 'ml'])) {
        return $_COOKIE['site_lang'];
    }
    return 'en'; // default English
}

function t($en, $ml) {
    return get_current_lang() === 'ml' ? ($ml ?: $en) : $en;
}

function base_url($path = '') {
    // Determine the base URL dynamically
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    
    // Script name path
    $scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME']);
    $dir = dirname($scriptName);
    
    // Normalize root directory
    if ($dir === '/' || $dir === '\\') {
        $base = $protocol . $host;
    } else {
        // If in admin subdirectory, strip /admin
        $dir = preg_replace('#/admin$#', '', $dir);
        $base = $protocol . $host . $dir;
    }
    
    $base = rtrim($base, '/');
    $path = ltrim($path, '/');
    return $path ? $base . '/' . $path : $base;
}

function get_json_data($file) {
    $filePath = DATA_PATH . '/' . $file;
    if (!file_exists($filePath)) {
        return [];
    }
    $content = file_get_contents($filePath);
    return json_decode($content, true) ?: [];
}

function save_json_data($file, $data) {
    $filePath = DATA_PATH . '/' . $file;
    return file_put_contents($filePath, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

function get_settings() {
    return get_json_data('settings.json');
}

function save_settings($data) {
    return save_json_data('settings.json', $data);
}

function get_categories() {
    return get_json_data('categories.json');
}

function get_category_by_id($catId) {
    $cats = get_categories();
    foreach ($cats as $cat) {
        if ($cat['id'] === $catId || $cat['slug'] === $catId) {
            return $cat;
        }
    }
    return null;
}

function get_articles($category = null, $featured = null, $limit = 0, $offset = 0) {
    $articles = get_json_data('articles.json');
    
    // Sort by date descending
    usort($articles, function($a, $b) {
        return strtotime($b['date']) - strtotime($a['date']);
    });
    
    // Filter by category
    if ($category) {
        $articles = array_filter($articles, function($item) use ($category) {
            return $item['category'] === $category;
        });
    }
    
    // Filter by featured
    if ($featured !== null) {
        $articles = array_filter($articles, function($item) use ($featured) {
            return ($item['featured'] ?? false) === $featured;
        });
    }
    
    $articles = array_values($articles);
    
    if ($limit > 0) {
        return array_slice($articles, $offset, $limit);
    }
    
    return $articles;
}

function get_article_by_id($id) {
    $articles = get_json_data('articles.json');
    foreach ($articles as $art) {
        if ($art['id'] === $id || ($art['slug'] ?? '') === $id) {
            return $art;
        }
    }
    return null;
}

function get_breaking_news() {
    $articles = get_json_data('articles.json');
    $breaking = [];
    foreach ($articles as $art) {
        if (!empty($art['breaking'])) {
            $breaking[] = [
                'id' => $art['id'],
                'en' => $art['title_en'],
                'ml' => $art['title_ml'],
                'url' => base_url('article.php?id=' . urlencode($art['id']))
            ];
        }
    }
    
    // Also include custom breaking ticker announcements from settings
    $settings = get_settings();
    if (!empty($settings['breaking_news_items'])) {
        foreach ($settings['breaking_news_items'] as $item) {
            $breaking[] = [
                'id' => null,
                'en' => $item['en'],
                'ml' => $item['ml'],
                'url' => null
            ];
        }
    }
    
    return $breaking;
}

function search_articles($query) {
    if (empty($query)) return [];
    $articles = get_json_data('articles.json');
    $q = mb_strtolower(trim($query));
    
    $results = [];
    foreach ($articles as $art) {
        $searchSpace = mb_strtolower(
            $art['title_en'] . ' ' . 
            $art['title_ml'] . ' ' . 
            $art['summary_en'] . ' ' . 
            $art['summary_ml'] . ' ' . 
            strip_tags($art['content_en']) . ' ' . 
            strip_tags($art['content_ml']) . ' ' . 
            $art['category'] . ' ' . 
            $art['author']
        );
        if (strpos($searchSpace, $q) !== false) {
            $results[] = $art;
        }
    }
    
    usort($results, function($a, $b) {
        return strtotime($b['date']) - strtotime($a['date']);
    });
    
    return $results;
}

function save_article($articleData) {
    $articles = get_json_data('articles.json');
    $exists = false;
    
    if (empty($articleData['id'])) {
        // Generate new ID based on title
        $slug = preg_replace('/[^a-z0-9]+/i', '-', strtolower($articleData['title_en']));
        $articleData['id'] = trim($slug, '-') . '-' . time();
    }
    
    foreach ($articles as $idx => $art) {
        if ($art['id'] === $articleData['id']) {
            $articles[$idx] = array_merge($art, $articleData);
            $exists = true;
            break;
        }
    }
    
    if (!$exists) {
        array_unshift($articles, $articleData);
    }
    
    save_json_data('articles.json', $articles);
    return $articleData['id'];
}

function delete_article($id) {
    $articles = get_json_data('articles.json');
    $filtered = array_filter($articles, function($art) use ($id) {
        return $art['id'] !== $id;
    });
    return save_json_data('articles.json', array_values($filtered));
}

function add_subscriber($email, $phone = '', $type = 'newsletter') {
    $subs = get_json_data('subscribers.json');
    foreach ($subs as $s) {
        if (!empty($email) && ($s['email'] ?? '') === $email) {
            return ['status' => 'exists', 'message' => 'Already subscribed!'];
        }
    }
    $subs[] = [
        'email' => $email,
        'phone' => $phone,
        'subscribed_at' => date('Y-m-d H:i:s'),
        'type' => $type
    ];
    save_json_data('subscribers.json', $subs);
    return ['status' => 'success', 'message' => 'Thank you for subscribing!'];
}
?>
