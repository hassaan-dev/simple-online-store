# Online Shop - Order Management System

A simplified order management system for an online shop built with Laravel and Bootstrap. This system allows customers to browse products, add them to their cart, and place orders.

## Features

### Customer Features
- Browse products
- Register and login
- Add products to cart
- Checkout and place orders
- View order history and details

## Installation

## Installation

1. Clone the repository

```

git clone [https://github.com/hassaan-dev/simple-online-store](https://github.com/hassaan-dev/simple-online-store)  
cd online-shop

```

2. Install PHP dependencies

```

composer install

```

3. Create and configure the environment file

```

cp .env.example .env

```

4. Configure your database settings in `.env` file

```

DB_CONNECTION=mysql  
DB_HOST=127.0.0.1  
DB_PORT=3306  
DB_DATABASE=online_shop  
DB_USERNAME=root  
DB_PASSWORD=root

```

5. Generate application key

```

php artisan key:generate

```

6. Run database migrations and seed data

```

php artisan migrate --seed

```

7. Create a symbolic link for storage

```

php artisan storage:link

```

## Assumptions and Limitations

- This is a simplified system focused on core functionality without advanced features like payment processing.
- Product images are stored in the `public/images` directory. In a production environment, you would use cloud storage.
- The shopping cart uses browser localStorage, so cart data is not persistent across different devices or browsers.
- Order processing is simplified without inventory management beyond basic stock level checks.
- There is no email notification system for order status updates.

## Demo Credentials

### Customer Account
- Email: user@example.com
- Password: password

## Development Stack
- Backend: Laravel 12 with MySQL
- Frontend: Bootstrap 5.3.5 with plain JavaScript
- Development Environment: MAMP Pro on macOS 15 with PHP 8.2

## Setup and Run Instructions

1.  Create and set up the project:

```bash
# Create a new Laravel project
composer create-project laravel/laravel:^12.0 online-shop
cd online-shop

# Run migrations and seeders
php artisan migrate --seed

# Create a symbolic link for storage
php artisan storage:link

```

2.  Set up the local development URL:

    -   Configure MAMP Pro to point to the project directory
    -   Set the document root to the `public` folder
    -   Configure the domain to be `dev-online-shop.test`
3.  Make sure to create a `public/images` directory and add some placeholder product images (smartphone.jpg, laptop.jpg, headphones.jpg, smartwatch.jpg, tablet.jpg) or modify the product seeder to use different images.

4.  Visit the site at [http://dev-online-shop.test](http://dev-online-shop.test) and use the provided credentials to log in.

