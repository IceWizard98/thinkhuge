
# Thinkhuge VPS Platform

This project is a web platform for managing and selling VPS (Virtual Private Server) services, specifically optimized for Forex trading.

## Setup Instructions

### Docker Environment
The project includes a `docker-compose.yml` file that sets up the complete development environment. To start the environment:

```bash
docker-compose up -d
```

### Database Initialization
1. Access phpMyAdmin at http://localhost:8080
2. Import the `init.sql` file to create the necessary database tables and insert initial data

### Accessing Admin Panel
Once the environment is running and the database is initialized:

- URL: http://localhost/login/
- Username: admin@admin.com
- Password: admin

## Features
- VPS Plans Management
- User Authentication
- Admin Dashboard
- Automated Billing System
- Forex-optimized VPS configurations

## Tech Stack
- PHP
- MySQL
- Docker
- CSS
