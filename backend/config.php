<?php
// Database configuration
define('DB_HOST', getenv('DB_HOST') ?: 'database');
define('DB_USER', getenv('DB_USER') ?: 'app_user');
define('DB_PASSWORD', getenv('DB_PASSWORD') ?: 'app_password');
define('DB_NAME', getenv('DB_NAME') ?: 'visitor_tracker');

// Create database connection
function getDBConnection() {
    static $conn = null;
    
    if ($conn === null) {
        try {
            $conn = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
                DB_USER,
                DB_PASSWORD,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
        } catch (PDOException $e) {
            error_log("Database connection failed: " . $e->getMessage());
            throw $e;
        }
    }
    
    return $conn;
}
?>
