<?php
/**
 * URL Shortener Configuration File
 *
 * IMPORTANT: Update these values with your actual database credentials
 * You can find these credentials in your Hostinger control panel (hPanel)
 * under "Databases" > "MySQL Databases"
 */

// Database Configuration
define('DB_HOST', 'localhost');           // Usually 'localhost' for Hostinger
define('DB_NAME', 'your_database_name');  // Your database name from Hostinger
define('DB_USER', 'your_database_user');  // Your database username
define('DB_PASS', 'your_database_password'); // Your database password

// Site Configuration
define('SITE_URL', 'https://ragilmalik.com'); // Your domain (no trailing slash)
define('SITE_NAME', 'RagilMalik URL Shortener'); // Your site name

// Security Settings
define('ADMIN_PASSWORD', 'changeme123'); // Change this to a strong password for admin panel

// URL Generation Settings
define('SHORT_CODE_LENGTH', 6); // Length of generated short codes (6-10 recommended)

// Analytics Settings
define('TRACK_CLICKS', true); // Set to false to disable click tracking

// Error Reporting (set to false in production)
define('DEBUG_MODE', false); // Set to true only when debugging issues

if (DEBUG_MODE) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Database Connection
function getDBConnection() {
    try {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        return new PDO($dsn, DB_USER, DB_PASS, $options);
    } catch (PDOException $e) {
        if (DEBUG_MODE) {
            die("Database connection failed: " . $e->getMessage());
        } else {
            die("Database connection failed. Please contact the administrator.");
        }
    }
}

// Helper function to generate random short code
function generateShortCode($length = SHORT_CODE_LENGTH) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $code = '';
    $max = strlen($characters) - 1;

    for ($i = 0; $i < $length; $i++) {
        $code .= $characters[random_int(0, $max)];
    }

    return $code;
}

// Helper function to validate URL
function isValidUrl($url) {
    return filter_var($url, FILTER_VALIDATE_URL) !== false;
}

// Helper function to sanitize URL
function sanitizeUrl($url) {
    $url = trim($url);

    // Add https:// if no protocol is specified
    if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
        $url = "https://" . $url;
    }

    return $url;
}

// Helper function to verify admin password
function verifyAdminPassword($password) {
    return hash_equals(ADMIN_PASSWORD, $password);
}
?>
