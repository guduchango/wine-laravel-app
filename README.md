# 🍷 Wine API - Laravel + Sanctum

This is a RESTful API built with Laravel, designed to work with a frontend application developed in Vue.js. The API allows you to manage a wine catalog, including features like creation, editing, filtering, and user authentication using Laravel Sanctum.

## 🚀 Technologies Used

- **Laravel 10+**
- **Laravel Sanctum** for token-based authentication
- **MySQL / PostgreSQL / SQLite** (based on configuration)
- **Eloquent ORM**
- **Laravel Artisan** for command-line tools
- **RESTful API** with protected and public routes

## 📦 Main Features

- User registration and login
- Token generation using Sanctum
- Full CRUD for wines
- Filtering by type, winery, year, country, etc.
- Wine associations with wineries, grape types, and regions
- Authentication middleware to protect routes
- Clean and scalable folder structure
- Consistent JSON responses

## 🗂️ Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   ├── Middleware/
├── Models/
routes/
├── api.php
```

## 🛠️ Installation & Usage

```bash
git clone git@github.com:guduchango/wine-laravel-app.git
cd wine-api
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

## 🔐 Authentication with Sanctum

To access protected routes:

1. Register or log in with a user account
2. Copy the received token
3. Include the token in the request headers:

```
Authorization: Bearer YOUR_TOKEN
```

## 📄 Main Routes

```
POST   /api/register     -> Register a new user
POST   /api/login        -> Login and receive a token
GET    /api/wines        -> List wines (protected)
POST   /api/wines        -> Create a wine (protected)
PUT    /api/wines/{id}   -> Edit a wine (protected)
DELETE /api/wines/{id}   -> Delete a wine (protected)
```

## 📬 Contact

For questions or collaboration:

- GitHub: [@guduchango](https://github.com/guduchango)
- Email: hello@edgardoponce.com

---

> This API is part of a larger project that includes a Vue.js frontend. More details coming soon!
