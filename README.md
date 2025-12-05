## Team Builder

Small Laravel 12 + Inertia/Vue app for managing teams and players.

### Requirements
- PHP 8.3, Composer
- Node.js 20+, npm
- MySQL (or compatible) configured in `.env`

### Setup
1) Install PHP deps: `composer install`
2) Install JS deps: `npm install`
3) Copy env: `cp .env.example .env` (or `copy` on Windows), then update DB/mail keys
4) Generate app key: `php artisan key:generate`
5) Run migrations: `php artisan migrate`
6) Seed sample data (teams/players): `php artisan db:seed`
7) Dev server: `npm run dev` (or `composer run dev` if configured)

### Tests
- Run the focused suite as needed, e.g. `php artisan test tests/Feature/DashboardTest.php`

### Handy commands
- Re-run seeders only: `php artisan db:seed --no-interaction`
- Format PHP (dirty files): `vendor/bin/pint --dirty`
