<?php
/**
 * URL Shortener Redirect Handler
 * This file handles the redirection from short URLs to original URLs
 * It also tracks click analytics if enabled
 */

require_once 'config.php';

// Get the short code from the request
$requestUri = $_SERVER['REQUEST_URI'];
$shortCode = trim($requestUri, '/');

// Remove query parameters if any
if (strpos($shortCode, '?') !== false) {
    $shortCode = substr($shortCode, 0, strpos($shortCode, '?'));
}

// If short code is empty or is a known file/directory, skip redirect
if (empty($shortCode) ||
    $shortCode === 'index.php' ||
    $shortCode === 'admin.php' ||
    $shortCode === 'api.php' ||
    $shortCode === 'redirect.php' ||
    strpos($shortCode, '.') !== false) {
    return;
}

try {
    $db = getDBConnection();

    // Fetch the URL from database
    $stmt = $db->prepare("
        SELECT id, original_url, active
        FROM urls
        WHERE short_code = ?
        LIMIT 1
    ");

    $stmt->execute([$shortCode]);
    $url = $stmt->fetch();

    if (!$url) {
        // Short URL not found
        header("HTTP/1.0 404 Not Found");
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>404 - Short URL Not Found</title>
            <style>
                * { margin: 0; padding: 0; box-sizing: border-box; }
                body {
                    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                    min-height: 100vh;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    color: #fff;
                }
                .container {
                    text-align: center;
                    padding: 40px;
                    background: rgba(255, 255, 255, 0.1);
                    border-radius: 20px;
                    backdrop-filter: blur(10px);
                    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
                }
                h1 { font-size: 72px; margin-bottom: 20px; }
                p { font-size: 20px; margin-bottom: 30px; }
                a {
                    color: #fff;
                    text-decoration: none;
                    padding: 12px 30px;
                    background: rgba(255, 255, 255, 0.2);
                    border-radius: 25px;
                    display: inline-block;
                    transition: all 0.3s ease;
                }
                a:hover {
                    background: rgba(255, 255, 255, 0.3);
                    transform: translateY(-2px);
                }
            </style>
        </head>
        <body>
            <div class="container">
                <h1>404</h1>
                <p>Short URL not found</p>
                <a href="/">Create a new short URL</a>
            </div>
        </body>
        </html>
        <?php
        exit();
    }

    // Check if URL is active
    if (!$url['active']) {
        header("HTTP/1.0 410 Gone");
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>410 - Link Disabled</title>
            <style>
                * { margin: 0; padding: 0; box-sizing: border-box; }
                body {
                    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
                    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
                    min-height: 100vh;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    color: #fff;
                }
                .container {
                    text-align: center;
                    padding: 40px;
                    background: rgba(255, 255, 255, 0.1);
                    border-radius: 20px;
                    backdrop-filter: blur(10px);
                    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
                }
                h1 { font-size: 72px; margin-bottom: 20px; }
                p { font-size: 20px; margin-bottom: 30px; }
                a {
                    color: #fff;
                    text-decoration: none;
                    padding: 12px 30px;
                    background: rgba(255, 255, 255, 0.2);
                    border-radius: 25px;
                    display: inline-block;
                    transition: all 0.3s ease;
                }
                a:hover {
                    background: rgba(255, 255, 255, 0.3);
                    transform: translateY(-2px);
                }
            </style>
        </head>
        <body>
            <div class="container">
                <h1>410</h1>
                <p>This short URL has been disabled</p>
                <a href="/">Create a new short URL</a>
            </div>
        </body>
        </html>
        <?php
        exit();
    }

    // Update click count and last accessed time
    $stmt = $db->prepare("
        UPDATE urls
        SET clicks = clicks + 1, last_accessed = CURRENT_TIMESTAMP
        WHERE id = ?
    ");
    $stmt->execute([$url['id']]);

    // Track detailed click analytics if enabled
    if (TRACK_CLICKS) {
        $ipAddress = $_SERVER['REMOTE_ADDR'] ?? null;
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? null;
        $referer = $_SERVER['HTTP_REFERER'] ?? null;

        $stmt = $db->prepare("
            INSERT INTO clicks (url_id, ip_address, user_agent, referer)
            VALUES (?, ?, ?, ?)
        ");

        $stmt->execute([$url['id'], $ipAddress, $userAgent, $referer]);
    }

    // Perform the redirect
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: " . $url['original_url']);
    exit();

} catch (Exception $e) {
    if (DEBUG_MODE) {
        die("Error: " . $e->getMessage());
    } else {
        header("HTTP/1.0 500 Internal Server Error");
        die("An error occurred. Please try again later.");
    }
}
?>
