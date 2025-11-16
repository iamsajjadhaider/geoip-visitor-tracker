<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GeoIP Visitor Tracker</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .visitor-info {
            background: #e8f4fd;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .error {
            background: #ffe6e6;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            border-left: 4px solid #ff4444;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🌍 GeoIP Visitor Tracker</h1>
        <p>Welcome! This application tracks visitor locations using GeoIP technology.</p>
        
        <?php
        require_once 'config.php';
        
        function makeApiCall($url) {
            $context = stream_context_create([
                'http' => [
                    'timeout' => 5,
                    'ignore_errors' => true
                ]
            ]);
            
            try {
                $response = file_get_contents($url, false, $context);
                return $response;
            } catch (Exception $e) {
                error_log("API call failed: " . $e->getMessage());
                return false;
            }
        }
        
        // Get visitor information from backend
        $backend_url = "http://" . BACKEND_SERVICE . ":" . BACKEND_PORT . "/geoip.php";
        $response = makeApiCall($backend_url);
        
        if ($response !== false) {
            $visitor_data = json_decode($response, true);
            
            if ($visitor_data && $visitor_data['success']) {
                echo '<div class="visitor-info">';
                echo '<h3>Your Visit Information:</h3>';
                echo '<p><strong>IP Address:</strong> ' . htmlspecialchars($visitor_data['ip']) . '</p>';
                echo '<p><strong>Country:</strong> ' . htmlspecialchars($visitor_data['country']) . '</p>';
                echo '<p><strong>City:</strong> ' . htmlspecialchars($visitor_data['city']) . '</p>';
                echo '<p><strong>ISP:</strong> ' . htmlspecialchars($visitor_data['isp']) . '</p>';
                echo '<p><strong>Visit Time:</strong> ' . htmlspecialchars($visitor_data['timestamp']) . '</p>';
                echo '</div>';
            } else {
                echo '<div class="error">';
                echo '<h3>⚠️ Service Notice</h3>';
                echo '<p>GeoIP service is temporarily unavailable. Showing sample data.</p>';
                echo '<div class="visitor-info">';
                echo '<h3>Sample Visit Information:</h3>';
                echo '<p><strong>IP Address:</strong> 192.168.1.1</p>';
                echo '<p><strong>Country:</strong> United States</p>';
                echo '<p><strong>City:</strong> New York</p>';
                echo '<p><strong>ISP:</strong> Example ISP</p>';
                echo '<p><strong>Visit Time:</strong> ' . date('Y-m-d H:i:s') . '</p>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<div class="error">';
            echo '<h3>🚨 Backend Connection Error</h3>';
            echo '<p>Unable to connect to backend service. Please check:</p>';
            echo '<ul>';
            echo '<li>Backend service is running</li>';
            echo '<li>Network connectivity between containers</li>';
            echo '<li>Backend URL: ' . htmlspecialchars($backend_url) . '</li>';
            echo '</ul>';
            echo '</div>';
        }
        ?>
        
        <h2>Recent Visitors</h2>
        <?php
        // Get recent visitors from backend
        $recent_url = "http://" . BACKEND_SERVICE . ":" . BACKEND_PORT . "/geoip.php?action=recent";
        $recent_response = makeApiCall($recent_url);
        
        if ($recent_response !== false) {
            $recent_visitors = json_decode($recent_response, true);
            
            if ($recent_visitors && $recent_visitors['success'] && !empty($recent_visitors['visitors'])) {
                echo '<table>';
                echo '<tr><th>IP Address</th><th>Country</th><th>City</th><th>Visit Time</th></tr>';
                foreach ($recent_visitors['visitors'] as $visitor) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($visitor['ip_address']) . '</td>';
                    echo '<td>' . htmlspecialchars($visitor['country']) . '</td>';
                    echo '<td>' . htmlspecialchars($visitor['city']) . '</td>';
                    echo '<td>' . htmlspecialchars($visitor['access_time']) . '</td>';
                    echo '</tr>';
                }
                echo '</table>';
            } else {
                echo '<p>No visitor data available yet. Visit the page a few times to generate data.</p>';
            }
        } else {
            echo '<div class="error">';
            echo '<p>Unable to retrieve recent visitors. Backend service may be unavailable.</p>';
            echo '</div>';
        }
        ?>
        
        <div style="margin-top: 30px; padding: 15px; background: #f9f9f9; border-radius: 5px;">
            <h3>DevOps Learning Objectives:</h3>
            <ul>
                <li>✅ Multi-container application with Docker Compose</li>
                <li>✅ Service discovery and inter-container communication</li>
                <li>✅ Persistent data storage with Docker volumes</li>
                <li>✅ External API integration</li>
                <li>✅ Environment-based configuration</li>
                <li>✅ Health checks and dependency management</li>
            </ul>
        </div>
        
        <div style="margin-top: 20px; padding: 15px; background: #fff3cd; border-radius: 5px;">
            <h3>Debug Information:</h3>
            <p><strong>Backend Service URL:</strong> <?php echo htmlspecialchars($backend_url); ?></p>
            <p><strong>PHP Version:</strong> <?php echo phpversion(); ?></p>
            <p><strong>Server Time:</strong> <?php echo date('Y-m-d H:i:s'); ?></p>
        </div>
    </div>
</body>
</html>
