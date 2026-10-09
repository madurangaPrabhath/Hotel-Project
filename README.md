<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Hotel-Project

A hotel management system built with **Laravel 12** and **Laravel Jetstream (Livewire stack)**. The project provides a solid authentication and user-management foundation — including registration with phone numbers, profile management, two-factor authentication, and role (`usertype`) support — on which hotel features (rooms, bookings, staff, etc.) will be built.

## Tech Stack

| Layer | Technology |
|---|---|
| Framework | [Laravel 12](https://laravel.com) (PHP ^8.2) |
| Authentication | [Laravel Fortify](https://laravel.com/docs/fortify) + [Laravel Jetstream](https://jetstream.laravel.com) (Livewire stack) |
| API Tokens | [Laravel Sanctum](https://laravel.com/docs/sanctum) |
| Frontend | [Livewire 3](https://livewire.laravel.com), Blade components, [Tailwind CSS](https://tailwindcss.com) |
| Build Tooling | [Vite 7](https://vitejs.dev), Axios |
| Database | MySQL (sessions & queues stored in database) |
| Testing | PHPUnit 11 |

## Features

- **Authentication** — registration, login, forgot/reset password, email verification, and logout.
- **Registration with phone number** — optional `phone` field collected during sign-up and stored on the user.
- **User roles foundation** — `usertype` column on users (defaults to `user`) for future role-based access (e.g. admin vs. guest).
- **Profile management** — update profile information, change password, log out of other browser sessions, and delete the account.
- **Two-factor authentication** — enable 2FA via an authenticator app, with recovery codes and a confirmation challenge at login.
- **Dashboard** — authenticated landing page at `/dashboard`.
- **Security hardening** — Sanctum token support, hashed passwords, and Jetstream session protection.

## Requirements

- PHP >= 8.2
- [Composer](https://getcomposer.org)
- Node.js >= 18 (with npm)
- MySQL (or any database supported by Laravel)

## Installation

### Quick setup

The repository ships with a Composer script that installs dependencies, prepares the `.env` file, generates the app key, runs migrations, and builds the frontend assets:

```bash
composer setup
```

### Manual setup

```bash
# 1. Install PHP dependencies
composer install

# 2. Create and configure the environment file
cp .env.example .env
php artisan key:generate

# 3. Configure database credentials in .env, then migrate
php artisan migrate

# 4. Install and build frontend assets
npm install
npm run build
```

### Environment configuration

Key values in `.env`:

```env
APP_NAME=Laravel
DB_CONNECTION=mysql
SESSION_DRIVER=database
QUEUE_CONNECTION=database
```

Update `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` to match your local MySQL instance before running migrations.

## Development

Run the full development stack (server, queue worker, logs, and Vite hot-reload) with a single command:

```bash
composer dev
```

This starts, concurrently:

| Name | Process |
|---|---|
| server | `php artisan serve` |
| queue | `php artisan queue:listen --tries=1 --timeout=0` |
| logs | `php artisan pail --timeout=0` |
| vite | `npm run dev` |

You can also run the individual pieces yourself:

```bash
php artisan serve     # application server (http://localhost:8000)
npm run dev           # Vite dev server with HMR
npm run build         # production asset build
```

## Testing

```bash
composer test
```

This clears the configuration cache and runs the PHPUnit test suite defined in `phpunit.xml`.

## Project Structure

```
Hotel-Project/
├── app/
│   ├── Actions/
│   │   ├── Fortify/          # Register, update profile/password actions
│   │   └── Jetstream/        # Account deletion action
│   ├── Http/Controllers/     # Base controller (app controllers to come)
│   ├── Models/               # Eloquent models (User)
│   ├── Providers/            # Fortify, Jetstream, app service providers
│   └── View/Components/      # App & guest layout components
├── config/                   # App configuration (jetstream.php, fortify.php, ...)
├── database/
│   ├── migrations/           # Schema (users w/ phone & usertype, 2FA, passkeys, tokens)
│   ├── factories/
│   └── seeders/
├── public/                   # Web root
├── resources/
│   └── views/                # Blade templates (auth, profile, dashboard, components)
├── routes/
│   ├── web.php               # "/" welcome & "/dashboard" (auth-protected)
│   └── api.php
└── tests/                    # PHPUnit tests
```

## Roadmap

Current state is the authentication/user-management foundation. Planned hotel domain features:

- Room types & inventory management
- Booking & reservation system
- Guest records and stay history
- Admin panel using the `usertype` role field
- Payments and invoicing

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
