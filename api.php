<?php
/**
 * URL Shortener API Endpoint
 * Handles all API requests for creating, retrieving, and managing short URLs
 */

require_once 'config.php';

// Set JSON response header
header('Content-Type: application/json');

// Enable CORS if needed
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Get request method and action
$method = $_SERVER['REQUEST_METHOD'];
$action = isset($_GET['action']) ? $_GET['action'] : '';

try {
    $db = getDBConnection();

    // Route requests based on action
    switch ($action) {
        case 'shorten':
            if ($method !== 'POST') {
                throw new Exception('Method not allowed', 405);
            }
            handleShorten($db);
            break;

        case 'stats':
            if ($method !== 'GET') {
                throw new Exception('Method not allowed', 405);
            }
            handleStats($db);
            break;

        case 'list':
            if ($method !== 'POST') {
                throw new Exception('Method not allowed', 405);
            }
            handleList($db);
            break;

        case 'delete':
            if ($method !== 'POST') {
                throw new Exception('Method not allowed', 405);
            }
            handleDelete($db);
            break;

        case 'toggle':
            if ($method !== 'POST') {
                throw new Exception('Method not allowed', 405);
            }
            handleToggle($db);
            break;

        default:
            throw new Exception('Invalid action', 400);
    }
} catch (Exception $e) {
    $code = $e->getCode() ?: 500;
    http_response_code($code);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}

/**
 * Handle URL shortening request
 */
function handleShorten($db) {
    $input = json_decode(file_get_contents('php://input'), true);

    if (!isset($input['url']) || empty($input['url'])) {
        throw new Exception('URL is required', 400);
    }

    $originalUrl = sanitizeUrl($input['url']);

    if (!isValidUrl($originalUrl)) {
        throw new Exception('Invalid URL format', 400);
    }

    // Check for custom short code
    $customCode = isset($input['custom']) ? trim($input['custom']) : '';
    $isCustom = !empty($customCode);

    // Get desired length (for random codes)
    $codeLength = isset($input['length']) ? intval($input['length']) : SHORT_CODE_LENGTH;

    // Validate length
    if ($codeLength < MIN_CODE_LENGTH || $codeLength > MAX_CODE_LENGTH) {
        $codeLength = SHORT_CODE_LENGTH; // Fall back to default
    }

    if ($isCustom) {
        // Validate custom code (alphanumeric, 3-20 chars)
        if (!preg_match('/^[a-zA-Z0-9]{3,20}$/', $customCode)) {
            throw new Exception('Custom code must be 3-20 alphanumeric characters', 400);
        }

        // Check if custom code already exists
        $stmt = $db->prepare("SELECT id FROM urls WHERE short_code = ?");
        $stmt->execute([$customCode]);

        if ($stmt->fetch()) {
            throw new Exception('This custom code is already taken', 400);
        }

        $shortCode = $customCode;
    } else {
        // Generate unique random short code with specified length
        do {
            $shortCode = generateShortCode($codeLength);
            $stmt = $db->prepare("SELECT id FROM urls WHERE short_code = ?");
            $stmt->execute([$shortCode]);
        } while ($stmt->fetch());
    }

    // Insert into database
    $stmt = $db->prepare("
        INSERT INTO urls (short_code, original_url, custom)
        VALUES (?, ?, ?)
    ");

    $stmt->execute([$shortCode, $originalUrl, $isCustom ? 1 : 0]);

    // Return success response
    echo json_encode([
        'success' => true,
        'short_code' => $shortCode,
        'short_url' => SITE_URL . '/' . $shortCode,
        'original_url' => $originalUrl
    ]);
}

/**
 * Handle stats request for a short URL
 */
function handleStats($db) {
    $shortCode = isset($_GET['code']) ? $_GET['code'] : '';

    if (empty($shortCode)) {
        throw new Exception('Short code is required', 400);
    }

    $stmt = $db->prepare("
        SELECT id, original_url, created_at, clicks, last_accessed, custom
        FROM urls
        WHERE short_code = ?
    ");

    $stmt->execute([$shortCode]);
    $url = $stmt->fetch();

    if (!$url) {
        throw new Exception('Short URL not found', 404);
    }

    echo json_encode([
        'success' => true,
        'stats' => [
            'short_code' => $shortCode,
            'original_url' => $url['original_url'],
            'created_at' => $url['created_at'],
            'clicks' => $url['clicks'],
            'last_accessed' => $url['last_accessed'],
            'is_custom' => (bool)$url['custom']
        ]
    ]);
}

/**
 * Handle list request (requires admin password)
 */
function handleList($db) {
    $input = json_decode(file_get_contents('php://input'), true);

    if (!isset($input['password']) || !verifyAdminPassword($input['password'])) {
        throw new Exception('Invalid admin password', 403);
    }

    $page = isset($input['page']) ? max(1, intval($input['page'])) : 1;
    $perPage = 20;
    $offset = ($page - 1) * $perPage;

    // Get total count
    $stmt = $db->query("SELECT COUNT(*) as total FROM urls");
    $total = $stmt->fetch()['total'];

    // Get URLs with pagination
    $stmt = $db->prepare("
        SELECT id, short_code, original_url, created_at, clicks, last_accessed, custom, active
        FROM urls
        ORDER BY created_at DESC
        LIMIT ? OFFSET ?
    ");

    $stmt->execute([$perPage, $offset]);
    $urls = $stmt->fetchAll();

    echo json_encode([
        'success' => true,
        'urls' => $urls,
        'pagination' => [
            'page' => $page,
            'per_page' => $perPage,
            'total' => $total,
            'total_pages' => ceil($total / $perPage)
        ]
    ]);
}

/**
 * Handle delete request (requires admin password)
 */
function handleDelete($db) {
    $input = json_decode(file_get_contents('php://input'), true);

    if (!isset($input['password']) || !verifyAdminPassword($input['password'])) {
        throw new Exception('Invalid admin password', 403);
    }

    if (!isset($input['id']) || empty($input['id'])) {
        throw new Exception('URL ID is required', 400);
    }

    $stmt = $db->prepare("DELETE FROM urls WHERE id = ?");
    $stmt->execute([$input['id']]);

    if ($stmt->rowCount() === 0) {
        throw new Exception('URL not found', 404);
    }

    echo json_encode([
        'success' => true,
        'message' => 'URL deleted successfully'
    ]);
}

/**
 * Handle toggle active status (requires admin password)
 */
function handleToggle($db) {
    $input = json_decode(file_get_contents('php://input'), true);

    if (!isset($input['password']) || !verifyAdminPassword($input['password'])) {
        throw new Exception('Invalid admin password', 403);
    }

    if (!isset($input['id']) || empty($input['id'])) {
        throw new Exception('URL ID is required', 400);
    }

    $stmt = $db->prepare("UPDATE urls SET active = NOT active WHERE id = ?");
    $stmt->execute([$input['id']]);

    if ($stmt->rowCount() === 0) {
        throw new Exception('URL not found', 404);
    }

    echo json_encode([
        'success' => true,
        'message' => 'URL status toggled successfully'
    ]);
}
?>
