<?php
// api.php - Lightweight API endpoints for NEWS @ DOHA
require_once __DIR__ . '/includes/db.php';

header('Content-Type: application/json; charset=utf-8');

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'subscribe':
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
            exit;
        }

        $input = json_decode(file_get_contents('php://input'), true);
        $contact = trim($input['contact'] ?? $_POST['contact'] ?? '');

        if (empty($contact)) {
            echo json_encode(['status' => 'error', 'message' => 'Contact details cannot be empty.']);
            exit;
        }

        $email = filter_var($contact, FILTER_VALIDATE_EMAIL) ? $contact : '';
        $phone = empty($email) ? $contact : '';

        $result = add_subscriber($email, $phone, 'web_newsletter');
        echo json_encode($result);
        break;

    case 'rates':
        $settings = get_settings();
        echo json_encode([
            'status' => 'success',
            'base' => 'QAR',
            'rates' => $settings['exchange_rates']['rates'] ?? []
        ]);
        break;

    case 'breaking':
        $items = get_breaking_news();
        echo json_encode([
            'status' => 'success',
            'items' => $items
        ]);
        break;

    case 'search':
        $q = trim($_GET['q'] ?? '');
        $results = search_articles($q);
        $clean = array_map(function($a) {
            return [
                'id' => $a['id'],
                'title_en' => $a['title_en'],
                'title_ml' => $a['title_ml'],
                'category' => $a['category'],
                'date' => $a['date'],
                'image' => $a['image'],
                'url' => base_url('article.php?id=' . urlencode($a['id']))
            ];
        }, array_slice($results, 0, 10));

        echo json_encode([
            'status' => 'success',
            'query' => $q,
            'count' => count($results),
            'results' => $clean
        ]);
        break;

    default:
        echo json_encode([
            'status' => 'online',
            'service' => 'NEWS @ DOHA API',
            'version' => '1.0.0'
        ]);
        break;
}
?>
