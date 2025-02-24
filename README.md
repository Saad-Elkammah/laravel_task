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

### Authentication

- `POST /api/register` - Register a new user
  - Required fields: `name`, `email`, `password`, `password_confirmation`
- `POST /api/login` - Login user
  - Required fields: `email`, `password`
- `POST /api/logout` - Logout user (requires authentication)

### Tasks (requires authentication)

- `GET /api/tasks` - List all tasks
- `POST /api/tasks` - Create a new task
  - Required fields: `title`, `status` (pending/in-progress/completed)
- `PUT /api/tasks/{id}` - Update a task
  - Optional fields: `title`, `status`
- `DELETE /api/tasks/{id}` - Delete a task

## Authentication

The API uses Laravel Sanctum for authentication. After registration or login, you will receive a token. Include this token in subsequent requests:

```http
Authorization: Bearer your_token_here
```

## Example Usage

### Register a new user
```bash
curl -X POST http://localhost:8000/api/register \
  -H "Content-Type: application/json" \
  -d '{"name":"John Doe","email":"john@example.com","password":"password123","password_confirmation":"password123"}'
```

### Login
```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"john@example.com","password":"password123"}'
```

### Create a task (with authentication)
```bash
curl -X POST http://localhost:8000/api/tasks \
  -H "Authorization: Bearer your_token_here" \
  -H "Content-Type: application/json" \
  -d '{"title":"Complete project","status":"pending"}'
```
