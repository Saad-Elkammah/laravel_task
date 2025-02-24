# Laravel Task Manager API

A simple Laravel API for managing tasks with authentication using Laravel Sanctum.

## Requirements

- PHP 8.2+
- MySQL 5.7+
- Composer

## Installation

1. Clone the repository
```bash
git clone <repository-url>
cd laravel_task
```

2. Install dependencies
```bash
composer install
```

3. Copy environment file and configure your database
```bash
cp .env.example .env
```

4. Generate application key
```bash
php artisan key:generate
```

5. Run migrations
```bash
php artisan migrate
```

## API Endpoints

All endpoints require authentication using Laravel Sanctum.

### Tasks

- `GET /api/tasks` - List all tasks
- `POST /api/tasks` - Create a new task
  - Required fields: `title`, `status` (pending/in-progress/completed)
- `PUT /api/tasks/{id}` - Update a task
  - Optional fields: `title`, `status`
- `DELETE /api/tasks/{id}` - Delete a task

## Authentication

The API uses Laravel Sanctum for authentication. You need to create a user and generate a token to access the protected endpoints.
