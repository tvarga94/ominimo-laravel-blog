<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Ominimo Test Task - Laravel Blog

This is a Laravel-based blog project designed as a test task for Ominimo. The application includes user authentication, blog post management, comments, and role-based access control (RBAC) with an admin role.

---

## Getting Started

### 1️⃣ Clone the Repository
```sh
git clone https://github.com/your-repo/ominimo-laravel-blog.git
cd ominimo-laravel-blog
```

### 2️⃣ Create the `.env` File
Copy the `.env.example` file and update the database credentials.
```sh
cp .env.example .env
```
Modify the database credentials in `.env`:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

### 3️⃣ Make the Setup Script Executable
Make sure the setup script is executable and then run it.

```sh
chmod +x setup.sh
./setup.sh
```

The script will:
- Install dependencies (`composer install`)
- Run database migrations with seeders (`php artisan migrate --seed`)
- Start the local development server (`php artisan serve`)

### 4️⃣ Running Tests
To run **unit** and **feature** tests, execute:
```sh
php artisan test
```

---

## Features
- **User Authentication** (Laravel Breeze-based login/register)
- **Blog Posts** (Create, read, update, delete)
- **Comments** (Users can comment on posts)
- **Role-Based Access Control** (Admin can manage everything, users can only edit their content)
- **Repository Pattern** for clean and scalable code
- **Authorization Policies** to restrict access to post and comment actions
- **Unit & Feature Tests** for core functionalities

---

## Project Structure
```
📂 app
 ├── Http
 │   ├── Controllers (All controllers)
 │   ├── Requests (Validation requests)
 │   ├── Repositories (Repository pattern implementation)
 │   ├── Middleware (Custom middleware)
 │
 ├── Models (Eloquent models)

📂 database
 ├── factories (Model factories for seeders)
 ├── migrations (Database schema definitions)
 ├── seeders (Database seeders for users, posts, and comments)

📂 resources/views
 ├── posts (All post-related views)
 ├── comments (Comment section views)

📂 tests
 ├── Unit (Unit tests for repositories)
 ├── Feature (Feature tests for post & comment interactions)
```

---

## Useful Commands
| **Command** | **Description** |
|------------|----------------|
| `php artisan migrate` | Run database migrations |
| `php artisan migrate:rollback` | Rollback last migration |
| `php artisan db:seed` | Seed the database with test data |
| `php artisan route:list` | Show all available routes |
| `php artisan test` | Run all tests |
| `php artisan serve` | Start Laravel's local development server |

---

You can now access the application at `http://127.0.0.1:8000`.

---
