-- Create database and user (already created by environment variables, but ensure privileges)
GRANT ALL PRIVILEGES ON visitor_tracker.* TO 'app_user'@'%';

-- Use the database
USE visitor_tracker;

-- Create visitors table
CREATE TABLE IF NOT EXISTS visitors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ip_address VARCHAR(45) NOT NULL,
    country VARCHAR(100) NOT NULL,
    city VARCHAR(100) NOT NULL,
    isp VARCHAR(255) NOT NULL,
    latitude DECIMAL(10, 8) NULL,
    longitude DECIMAL(11, 8) NULL,
    access_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_ip (ip_address),
    INDEX idx_time (access_time),
    INDEX idx_country (country)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert sample data for demonstration
INSERT INTO visitors (ip_address, country, city, isp, latitude, longitude) VALUES
('8.8.8.8', 'United States', 'Mountain View', 'Google LLC', 37.405990, -122.078514),
('1.1.1.1', 'Australia', 'Sydney', 'Cloudflare', -33.868820, 151.209290),
('208.67.222.222', 'United States', 'San Francisco', 'Cisco OpenDNS', 37.774930, -122.419420);
