# Bill Payment Application - Wallet & Airtime Purchase

## Project Overview
This is a simple Laravel-based application designed for bill payments focusing on airtime purchases. The application simulates wallet funding and airtime purchase functionalities while ensuring the system is safe from concurrency issues. The application includes the following modules:

- **Authentication** (Register, Login, Logout)
- **Wallet Module** (Fund Wallet, Check Wallet Balance)
- **Purchase Module** (Airtime Purchase)
- **Transaction History** (Get Transaction List)
- **Network Providers** (Get List of Providers)

## Features:
- User authentication (register, login, logout)
- Wallet functionality (fund wallet, check balance)
- Airtime purchase functionality
- Transaction logging
- Concurrency protection using optimistic locking
- Pagination for transaction history
- Network provider list retrieval

## Prerequisites

Before you begin, ensure you have the following software installed:

- PHP (>= 8.2)
- Composer
- Laravel (>= 11.x)
- MySQL
- Postman (for testing APIs)

## Installation Guide

Follow these steps to set up the application locally:

### 1. Clone the Repository

```
git clone https://github.com/obinosteve/billpayment.git
cd billpayment
```

### 2. Install Dependencies

Run the following command to install the project’s PHP dependencies:

```
composer install
```

### 3. Set Up the Environment File

Create a `.env` file by copying the example `.env.example`:

```
cp .env.example .env
```

Configure the `.env` file for your local environment:
- Set the database connection details (`DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`)
- Set the `APP_KEY` by running:
  
  ```
  php artisan key:generate
  ```

### 4. Run Migrations and Seed the Database

The application includes migrations to set up the database schema and seeders to populate the database with initial data.

#### Run Migrations:

```
php artisan migrate
```

#### Run Seeders:

The database seeder will populate initial values for the network providers.

```
php artisan db:seed
```

If you want to specifically run the seeder for users and providers, you can do:

```
php artisan db:seed --class=NetworkProviderSeeder
```

### 5. Start the Development Server

Run the development server using Laravel’s built-in Artisan server:

```
php artisan serve
```

This will start the server on `http://127.0.0.1:8000`.

If you need to run the server on a different port, you can use:

```
php artisan serve --port=8080
```

### 6. Start the laravel queue worker

Start the laravel queue worker using the following

```
php artisan queue:work
```

### 7. Testing with Postman

You can now test the API endpoints using Postman:

- **Authentication:**
  - POST `/register` - Register a new user.
  - POST `/login` - Login and receive a token.
  - POST `/logout` - Logout and invalidate the token.

- **Wallet:**
  - GET `/wallet/balance` - Check wallet balance.
  - POST `/wallet/fund` - Fund wallet.

- **Purchase:**
  - POST `/purchase/airtime` - Purchase airtime (simulate the purchase).

- **Transactions:**
  - GET `/transactions` - Get the transaction history.

- **Providers:**
  - GET `/providers` - Get list of network providers.

---

## Security

- **User Token**: All endpoints require authentication via token.
- **Rate Limiting**: Limit the number of requests to certain endpoints (e.g., wallet funding, purchases).
- **Concurrency Protection**: The application handles wallet balance updates with optimistic locking to prevent race conditions.

---

## Troubleshooting

- **Missing `.env` file**: Ensure the `.env` file is correctly set up with the database credentials and `APP_KEY`.
- **Database Connection Issues**: Double-check the database configuration in the `.env` file.
- **Caching Issues**: If changes are not reflected, try clearing the application cache:

  ```
  php artisan config:cache
  php artisan route:cache
  ```


