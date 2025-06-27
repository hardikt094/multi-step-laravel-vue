

# Laravel Backend API for Lead Capture

This is the backend API for the Vue 3 multistep lead capture form. It is built with Laravel and provides endpoints for lead submission and dynamic platform type fetching.

## Requirements
- PHP 8.1+
- Composer
- SQLite/MySQL/PostgreSQL (or your preferred DB)
- Node.js & npm (for Laravel Mix, if needed)

## Setup Instructions

### 1. Install dependencies
```sh
composer install
```

### 2. Copy and configure environment file
```sh
cp .env.example .env
```
- Set your database connection in `.env` (e.g., `DB_CONNECTION=sqlite` or `DB_CONNECTION=mysql`)
- Set `APP_URL` to `http://127.0.0.1:8000`

### 3. Generate application key
```sh
php artisan key:generate
```

### 4. Run database migrations
```sh
php artisan migrate
```

### 5. (Optional) Seed the database
```sh
php artisan db:seed
```

### 6. Configure CORS for frontend integration
- Edit `config/cors.php`:
  ```php
  'paths' => ['api/*', 'sanctum/csrf-cookie'],
  'allowed_origins' => [
      'http://localhost:5173',
      'http://127.0.0.1:5173',
  ],
  'allowed_methods' => ['*'],
  'allowed_headers' => ['*'],
  'supports_credentials' => true,
  ```
- Then run:
  ```sh
  php artisan config:cache
  ```

### 7. Start the Laravel development server
```sh
php artisan serve
```

The API will be available at [http://127.0.0.1:8000/api](http://127.0.0.1:8000/api).

## API Endpoints
- **POST** `/api/leads` — Accepts lead form submissions.
- **GET** `/api/platform-types/{type}` — Returns available platforms for the given website type.

## Notes
- Make sure your database is running and accessible.
- For production, configure your environment and CORS settings appropriately.

## License
MIT
