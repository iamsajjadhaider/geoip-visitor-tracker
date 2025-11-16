<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');

// Add CORS headers for flexibility
if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');
}

require_once 'config.php';

function getClientIP() {
    $ip = '';
    
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
    }
    
    // Handle multiple IPs in X_FORWARDED_FOR
    $ip = explode(',', $ip)[0];
    
    return trim($ip);
}

function getGeoIPData($ip) {
    // Skip for private IPs
    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
        return [
            'country' => 'Local Network',
            'city' => 'Local',
            'isp' => 'Local Network',
            'lat' => null,
            'lon' => null
        ];
    }
    
    try {
        // Using ipapi.co free service
        $url = "http://ipapi.co/{$ip}/json/";
        $context = stream_context_create([
            'http' => [
                'timeout' => 5,
                'user_agent' => 'GeoIP Visitor Tracker/1.0',
                'ignore_errors' => true
            ]
        ]);
        
        $response = file_get_contents($url, false, $context);
        
        if ($response === false) {
            throw new Exception('Failed to fetch GeoIP data');
        }
        
        $data = json_decode($response, true);
        
        if ($data && !isset($data['error'])) {
            return [
                'country' => $data['country_name'] ?? 'Unknown',
                'city' => $data['city'] ?? 'Unknown',
                'isp' => $data['org'] ?? 'Unknown ISP',
                'lat' => $data['latitude'] ?? null,
                'lon' => $data['longitude'] ?? null
            ];
        }
    } catch (Exception $e) {
        error_log("GeoIP API error: " . $e->getMessage());
    }
    
    // Fallback data
    return [
        'country' => 'Unknown',
        'city' => 'Unknown',
        'isp' => 'Unknown ISP',
        'lat' => null,
        'lon' => null
    ];
}

function saveVisitorData($ip, $geoData) {
    try {
        $db = getDBConnection();
        
        $stmt = $db->prepare("
            INSERT INTO visitors (ip_address, country, city, isp, latitude, longitude) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        
        $result = $stmt->execute([
            $ip,
            $geoData['country'],
            $geoData['city'],
            $geoData['isp'],
            $geoData['lat'],
            $geoData['lon']
        ]);
        
        return $result ? $db->lastInsertId() : false;
    } catch (Exception $e) {
        error_log("Database error: " . $e->getMessage());
        return false;
    }
}

function getRecentVisitors($limit = 10) {
    try {
        $db = getDBConnection();
        
        $stmt = $db->prepare("
            SELECT ip_address, country, city, isp, access_time 
            FROM visitors 
            ORDER BY access_time DESC 
            LIMIT ?
        ");
        
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    } catch (Exception $e) {
        error_log("Database error: " . $e->getMessage());
        return [];
    }
}

// Main request handler
try {
    // Test database connection first
    $db = getDBConnection();
    
    $action = $_GET['action'] ?? 'track';
    
    if ($action === 'recent') {
        $visitors = getRecentVisitors();
        echo json_encode([
            'success' => true,
            'visitors' => $visitors,
            'count' => count($visitors)
        ]);
    } else {
        $clientIP = getClientIP();
        $geoData = getGeoIPData($clientIP);
        $saveResult = saveVisitorData($clientIP, $geoData);
        
        echo json_encode([
            'success' => (bool)$saveResult,
            'ip' => $clientIP,
            'country' => $geoData['country'],
            'city' => $geoData['city'],
            'isp' => $geoData['isp'],
            'timestamp' => date('Y-m-d H:i:s'),
            'database_saved' => (bool)$saveResult
        ]);
    }
} catch (Exception $e) {
    error_log("Main handler error: " . $e->getMessage());
    
    echo json_encode([
        'success' => false,
        'error' => 'Service temporarily unavailable',
        'debug' => $e->getMessage()
    ]);
}
?>
