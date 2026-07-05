# Laravel Photo Sharing App

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About This Application

This is a modern photo sharing social media application built with Laravel. The platform allows users to register, upload photos, comment on images, and like posts - creating an engaging community experience.

The application features:
- User authentication and profile management
- Photo upload and gallery browsing
- Commenting system for user engagement
- Like functionality to show appreciation for posts
- Database schema designed for scalability

## Features

### Core Functionality
- **User Management**: Registration, login, and profile management with roles
- **Photo Sharing**: Users can upload and browse photos
- **Comments**: Interactive commenting on photos
- **Likes**: Like functionality to show appreciation
- **Responsive Design**: Mobile-friendly interface

### Technical Features
- Laravel 13.x framework
- MySQL database with proper relationships
- Modern PHP practices
- Database migrations and seeds
- Unit testing capabilities
- Development environment setup scripts

## Installation

1. Clone the repository:
   ```bash
   git clone <repository-url>
   ```

2. Install dependencies:
   ```bash
   composer install
   npm install
   ```

3. Copy the environment file:
   ```bash
   cp .env.example .env
   ```

4. Generate application key:
   ```bash
   php artisan key:generate
   ```

5. Set up database:
   ```bash
   php artisan migrate --force
   ```

6. Start the development server:
   ```bash
   npm run dev
   ```

## Database Schema

The application uses a relational database with the following tables:

### Users Table
- `id`: Primary key
- `role`: User role (admin, user, etc.)
- `name`, `surname`, `nick`: User identification
- `email`: Unique email address
- `password`: Encrypted password
- `image`: Profile image path
- Timestamps for created/updated

### Images Table
- `id`: Primary key
- `user_id`: Foreign key to users table
- `image_path`: Path to the image file
- `description`: Description of the image
- Timestamps for created/updated

### Comments Table
- `id`: Primary key
- `user_id`: Foreign key to users table
- `image_id`: Foreign key to images table
- `content`: Comment text
- Timestamps for created/updated

### Likes Table
- `id`: Primary key
- `user_id`: Foreign key to users table
- `image_id`: Foreign key to images table
- Timestamps for created/updated

## Development

This project is set up with Laravel Breeze for the frontend, providing a modern development experience. The application includes:

- Modern PHP codebase following Laravel best practices
- Responsive UI components
- Comprehensive testing suite
- Development scripts for easy setup and running

## Contributing

Contributions are welcome! Please read our [contribution guidelines](https://laravel.com/docs/contributions) to get started.

## Code of Conduct

Please review and abide by our [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within this application, please send an e-mail to the development team via [security@example.com](mailto:security@example.com). All security vulnerabilities will be promptly addressed.

## License

This Laravel application is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).