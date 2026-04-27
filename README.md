# Rynna Stationery

Rynna Stationery is a web application built with Laravel for managing a stationery shop. It includes features for product management, order processing, vouchers, and an AI-powered customer support chatbot.

## Features

- **Product Management**: Browse and manage stationery products.
- **Order System**: Process customer orders with status tracking.
- **Voucher System**: Apply discounts to orders using vouchers.
- **AI Chatbot**: Integrated customer support powered by Google Gemini AI.
- **Admin Dashboard**: Comprehensive management interface for administrators.

## Tech Stack

- **Backend**: Laravel (PHP)
- **Database**: MySQL/SQLite
- **AI Integration**: Google Gemini API
- **Frontend**: Blade templates with Vanilla CSS/JS

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/MOS-dev-dev/RynnaStationery.git
   ```
2. Install dependencies:
   ```bash
   composer install
   npm install
   ```
3. Configure your environment:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. Run migrations:
   ```bash
   php artisan migrate
   ```
5. Start the development server:
   ```bash
   php artisan serve
   ```

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
