# Darak — Direct Syrian Property Marketplace

Laravel 12 MVP for connecting property owners and tenants directly in Damascus, Jaramana, and Sahnaya. The project follows the supplied plan: moderated listings, freshness confirmation, protected contact requests, reporting, owner subscriptions via manual Sham Cash review, and a separate admin moderation surface.

## Run locally

```bash
composer install
npm install
npm run build
php artisan migrate --seed
php artisan serve
php artisan queue:work
```

The project is configured for MySQL in `.env` (`darak`, port `3306`). Create the database before migrating. All database access uses Eloquent models and query builders. File cache is enabled to reduce repeated dashboard aggregate queries; clear it with `php artisan cache:clear` after operational changes.

Frontend assets are authored in `resources/scss` and `resources/js`, then compiled to `public/build` with Webpack. Queue-backed work is used for post-submission moderation notifications and is ready for future email/SMS integrations.

## Demo accounts

- Owner: `0999999999` / `password`
- Admin: `0888888888` / `password`

## Main routes

- `/` — public search and filters
- `/auth` — tenant/owner registration and phone-based login
- `/owner/dashboard` — owner listings, freshness confirmation, hide/reactivate, and subscription request
- `/admin/dashboard` — listing moderation and report resolution

The current machine runs PHP 8.2, so Composer selected Laravel 12 (the latest Laravel line compatible with this runtime). Laravel 13 requires PHP 8.3+; upgrade PHP before moving the application to Laravel 13.
