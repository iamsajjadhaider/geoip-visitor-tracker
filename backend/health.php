<?php
// Simple health check endpoint
header("Content-Type: application/json");
header("Cache-Control: no-cache");

try {
    // Check if we can connect to database
    require_once 'config.php';
    $db = getDBConnection();
    
    // Simple query to test database
    $stmt = $db->query("SELECT 1 as test");
    $result = $stmt->fetch();
    
    http_response_code(200);
    echo json_encode([
        "status" => "healthy",
        "service" => "backend",
        "database" => "connected",
        "timestamp" => date('Y-m-d H:i:s')
    ]);
    
} catch (Exception $e) {
    http_response_code(503);
    echo json_encode([
        "status" => "unhealthy",
        "service" => "backend", 
        "database" => "disconnected",
        "error" => $e->getMessage(),
        "timestamp" => date('Y-m-d H:i:s')
    ]);
}
?>
