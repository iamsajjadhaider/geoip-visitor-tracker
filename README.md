# 🌍 GeoIP Visitor Tracker

A comprehensive DevOps learning project demonstrating containerized 3-tier application architecture with Docker and Docker Compose. This application tracks visitor locations in real-time using GeoIP technology.

## 📋 Project Overview

The GeoIP Visitor Tracker is a fully containerized web application that demonstrates modern DevOps practices:
- **Real-time visitor tracking** with geographic location data
- **Multi-service architecture** with proper separation of concerns
- **External API integration** for GeoIP lookups
- **Persistent data storage** with proper volume management
- **Container networking** for inter-service communication

## 🏗️ Architecture
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│ Frontend        │    │ Backend         │    │ Database        │
│                 │    │                 │    │                 │
│ • Nginx         │◄───│ • Apache        │◄───│ • MySQL 8.0     │
│ • PHP 8.2       │    │ • PHP 8.2       │    │ • Persistent    │
│ • Port 8080     │    │ • GeoIP API     │    │ Volume          │
└─────────────────┘    └─────────────────┘    └─────────────────┘

## 🚀 Quick Start

### Prerequisites
- Docker Engine 20.10+
- Docker Compose 2.0+

### Running the Application

1. Clone the repository

   git clone  https://github.com/iamsajjadhaider/geoip-visitor-tracker.git
   cd geoip-visitor-tracker
   
Start the application

docker compose up -d
Access the application

Frontend: http://localhost:8080

Database: localhost:3306 (user: app_user, password: app_password)

View logs

docker compose logs -f
Stop the application

docker compose down
🛠️ Project Structure

geoip-visitor-tracker/
├── frontend/              # Nginx + PHP Frontend
│   ├── Dockerfile
│   ├── index.php         # Main landing page
│   ├── config.php        # Frontend configuration
│   └── nginx.conf        # Nginx configuration
├── backend/               # Apache + PHP Backend API
│   ├── Dockerfile
│   ├── geoip.php         # GeoIP API endpoint
│   ├── config.php        # Database configuration
│   └── health.php        # Health check endpoint
├── database/              # MySQL Database
│   └── init.sql          # Database schema and sample data
├── docker compose.yml     # Multi-container orchestration
└── README.md             # Project documentation

📊 Features
Real-time GeoIP Tracking: Automatically detects and displays visitor locations

Persistent Storage: MySQL database with Docker volume for data persistence

RESTful API: Clean backend service architecture with JSON responses

Responsive UI: Modern, mobile-friendly interface with visitor history

Health Monitoring: Container health checks and status monitoring

Error Handling: Comprehensive error handling with fallback mechanisms

🎯 Learning Objectives
This project demonstrates essential DevOps concepts:

✅ Containerization
Multi-service Docker architecture

Optimized Dockerfile practices

Container isolation and best practices

✅ Orchestration
Docker Compose for

need all in one box plz

# 🌍 GeoIP Visitor Tracker

A comprehensive DevOps learning project demonstrating containerized 3-tier application architecture with Docker and Docker Compose. This application tracks visitor locations in real-time using GeoIP technology.

## 📋 Project Overview

The GeoIP Visitor Tracker is a fully containerized web application that demonstrates modern DevOps practices:
- **Real-time visitor tracking** with geographic location data
- **Multi-service architecture** with proper separation of concerns
- **External API integration** for GeoIP lookups
- **Persistent data storage** with proper volume management
- **Container networking** for inter-service communication

## 🏗️ Architecture
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│ Frontend        │    │ Backend         │    │ Database        │
│                 │    │                 │    │                 │
│ • Nginx         │◄───│ • Apache        │◄───│ • MySQL 8.0     │
│ • PHP 8.2       │    │ • PHP 8.2       │    │ • Persistent    │
│ • Port 8080     │    │ • GeoIP API     │    │ Volume          │
└─────────────────┘    └─────────────────┘    └─────────────────┘

## 🚀 Quick Start

### Prerequisites
- Docker Engine 20.10+
- Docker Compose 2.0+

### Running the Application

1. **Clone the repository**
   ```bash
   git clone https://github.com/your-username/geoip-visitor-tracker.git
   cd geoip-visitor-tracker
Start the application

docker compose up -d
Access the application

Frontend: http://localhost:8080

Database: localhost:3306 (user: app_user, password: app_password)

View logs

docker compose logs -f
Stop the application

docker compose down

🛠️ Project Structure

geoip-visitor-tracker/
├── frontend/              # Nginx + PHP Frontend
│   ├── Dockerfile
│   ├── index.php         # Main landing page
│   ├── config.php        # Frontend configuration
│   └── nginx.conf        # Nginx configuration
├── backend/               # Apache + PHP Backend API
│   ├── Dockerfile
│   ├── geoip.php         # GeoIP API endpoint
│   ├── config.php        # Database configuration
│   └── health.php        # Health check endpoint
├── database/              # MySQL Database
│   └── init.sql          # Database schema and sample data
├── docker compose.yml     # Multi-container orchestration
└── README.md             # Project documentation

📊 Features
Real-time GeoIP Tracking: Automatically detects and displays visitor locations

Persistent Storage: MySQL database with Docker volume for data persistence

RESTful API: Clean backend service architecture with JSON responses

Responsive UI: Modern, mobile-friendly interface with visitor history

Health Monitoring: Container health checks and status monitoring

Error Handling: Comprehensive error handling with fallback mechanisms

🎯 Learning Objectives
This project demonstrates essential DevOps concepts:

✅ Containerization
Multi-service Docker architecture

Optimized Dockerfile practices

Container isolation and best practices

✅ Orchestration
Docker Compose for multi-container apps

Service dependencies and health checks

Environment-based configuration

✅ Data Management
Persistent volumes for database

Database initialization scripts

Data backup and recovery strategies

✅ Networking
Inter-container communication

Service discovery

Port mapping and exposure

✅ External Integrations
Third-party API consumption

Error handling for external services

Fallback mechanisms

🔧 Configuration
Environment Variables
Customize the application by setting these environment variables:

Variable	Default	Description
DB_HOST	database	Database hostname
DB_USER	app_user	Database user
DB_PASSWORD	app_password	Database password
DB_NAME	visitor_tracker	Database name
Port Configuration
Service	Container Port	Host Port
Frontend	80	8080
Backend	80	-
Database	3306	3306
🐳 Docker Commands
Development Commands

# Start all services
docker compose up -d

# Stop all services
docker compose down

# View service status
docker compose ps

# View service logs
docker compose logs -f
docker compose logs frontend
docker compose logs backend
docker compose logs database

# Rebuild specific service
docker compose build frontend
docker compose build backend

# Execute commands in containers
docker compose exec frontend bash
docker compose exec backend bash
docker compose exec database mysql -u app_user -papp_password visitor_tracker

Database Management

# Backup database
docker compose exec database mysqldump -u app_user -papp_password visitor_tracker > backup.sql

# Restore database
docker compose exec -T database mysql -u app_user -papp_password visitor_tracker < backup.sql

# Access MySQL console
docker compose exec database mysql -u app_user -papp_password visitor_tracker
🔍 Troubleshooting
Common Issues
Port 8080 already in use

bash
# Change frontend port in docker compose.yml
ports:
  - "8081:80"
Backend connection refused

# Check backend logs
docker compose logs backend

# Test backend health
docker compose exec backend curl http://localhost/health.php
Database connection issues

# Check database status
docker compose logs database

# Test database connection
docker compose exec backend mysql -h database -u app_user -papp_password -e "SHOW DATABASES;"
Debugging Commands

# Check container networking
docker network ls
docker network inspect geoip-visitor-tracker_app-network

# Check container resources
docker stats

# Clean up unused containers and images
docker system prune -f
📈 API Endpoints
Backend API
GET /geoip.php - Track current visitor and return GeoIP data

GET /geoip.php?action=recent - Get recent visitors (last 10)

GET /health.php - Health check endpoint

Response Format
json
{
  "success": true,
  "ip": "192.168.1.1",
  "country": "United States",
  "city": "New York",
  "isp": "Example ISP",
  "timestamp": "2024-01-15 10:30:00"
}
🗃️ Database Schema
sql
CREATE TABLE visitors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ip_address VARCHAR(45) NOT NULL,
    country VARCHAR(100) NOT NULL,
    city VARCHAR(100) NOT NULL,
    isp VARCHAR(255) NOT NULL,
    latitude DECIMAL(10, 8) NULL,
    longitude DECIMAL(11, 8) NULL,
    access_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
🤝 Contributing
Fork the repository

Create a feature branch: git checkout -b feature/new-feature

Make your changes and test: docker compose up --build

Commit your changes: git commit -m 'Add new feature'

Push to the branch: git push origin feature/new-feature

Submit a pull request

🎓 Next Steps for Learning
After mastering this project, consider exploring:

CI/CD Pipelines: Add GitHub Actions for automated testing and deployment

Container Orchestration: Migrate to Kubernetes with Helm charts

Monitoring: Add Prometheus and Grafana for metrics

Security: Implement HTTPS, security scanning, and secrets management

Infrastructure as Code: Convert to Terraform or Pulumi

Service Mesh: Implement Istio or Linkerd for advanced networking

🙏 Acknowledgments
GeoIP data provided by ipapi.co

PHP Docker images from Docker Hub

MySQL Docker image from Docker Hub

Happy Learning! 🚀

This project is designed for educational purposes to demonstrate real-world DevOps practices and containerized application development.
