
# Event Booking System Laravel 12

This project is a backend API for an Event Booking System built using Laravel 12.


## Features

- Authentication (Sanctum)
- Event & Ticket Management
- Booking & Mock Payment
- Role-based Access Control
- Middleware, Services & Traits
- Notifications & Queues
- Caching & Optimization
- Feature + Unit Testing

## Requirements

- PHP 8.1+
- Composer
- MySQL
- Laravel 12
- Postman (for API testing)

## Installation

1. Clone repository

```bash
  git clone https://github.com/kvnpayas/EventBookingBackend.git
  cd EventBookingBackend
```

2. Install dependencies

```bash
  composer install
```

3. Create .env file

```bash
  cp .env.example .env
```

4. Generate key

```bash
  php artisan key:generate
```

5. Install sanctum

```bash
  php artisan install:api
```

6. Configure Database

```bash
  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=event_booking
  DB_USERNAME=root
  DB_PASSWORD=
```

7. Run migrations + seeders

```bash
  php artisan migrate --seed
```