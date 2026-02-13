# Health Tracker - PHP/Laravel Application

Built with Laravel to track medications and vitals. Everything's stored in browser local storage, no database.

## Features

**Medication Management**
- Add medications with name, dosage, and frequency
- View all your medications in a list
- Remove medications when needed
- Data persists in browser local storage

**Vital Signs Logging**
- Log blood pressure, heart rate, and weight
- View history of all logged vitals with timestamps
- Newest entries shown first
- Everything saved to local storage

**User Authentication**
- Simple username-only login (demo purposes)
- PHP session-based auth
- Data is isolated per username
- Auto-logout after 10 minutes of inactivity

## Tech Stack

- Laravel 11.x (PHP 8.2+)
- Blade Templates with Bootstrap 5.3
- Browser Local Storage for data
- PHP Sessions for authentication
- Vanilla JavaScript

## Installation

```bash
# Clone the repo
git clone <repository-url>
cd php-health-tracker

# Install dependencies
composer install

# Set up environment
cp .env.example .env
php artisan key:generate

# Start the server
php artisan serve
```

Open `http://localhost:8000`

Can also be accessed on railway:
php-health-tracker-production.up.railway.app

## Usage

**Login**: Enter any username (try `john_doe` or `jane_smith`) - no password needed.

**Adding Medications**: Fill in the medication name, dosage (e.g., "20mg"), and frequency (e.g., "Once daily"). Click Add.

**Logging Vitals**: Enter your BP readings, heart rate, and weight. Click Log Vitals.

**Data Storage**: Everything is saved to your browser's local storage. Each username has its own data namespace, so multiple users can use the app on the same browser.

## Project Structure

Main files:
- `app/Http/Controllers/AuthController.php` - Login/logout handling
- `app/Http/Controllers/DashboardController.php` - Main dashboard
- `resources/views/auth/login.blade.php` - Login page
- `resources/views/dashboard.blade.php` - Main app interface
- `resources/views/layouts/app.blade.php` - Master layout
- `public/js/dashboard.js` - Dashboard functionality
- `public/js/login.js` - Login form handling
- `routes/web.php` - Application routes

## How It Works

The app uses PHP sessions for authentication (username only, no database). All medication and vitals data is stored in the browser's local storage using JavaScript. Each user's data is namespaced with their username (e.g., `medications-john_doe`).

The inactivity timer tracks mouse/keyboard activity and automatically logs you out after 10 minutes of no interaction.

## Notes

This is just a demo app. Obviously for real use you'd need actual database storage, passwords, proper auth middleware, etc. But it shows the basic concepts.


