# GiG Construction API

API-first Laravel 12 backend for managing projects, media, and client inquiries with multilingual support.

## Features
- 🔐 Fortify authentication with Sanctum API tokens
- 🗃️ Media handling via Spatie Media Library (S3-ready)
- 🌐 Translation loader for multilingual content
- 📨 Transactional email with Symfony Mailer (Mailgun)
- ⚡ Redis-powered cache and queues (Predis)
- 🛠️ Developer DX: Vite dev server, Boost/Pail diagnostics, Pint formatting, Pest tests

## Tech Stack
- **Framework:** Laravel 12 (PHP 8.2)
- **Auth/Security:** Fortify, Sanctum
- **Storage:** AWS S3 (Flysystem v3), Redis/Predis
- **Media & i18n:** Spatie Media Library, Spatie Translation Loader
- **Mail:** Symfony Mailer (Mailgun)
- **Frontend tooling:** Vite 7, Tailwind CSS 4, Axios, Laravel Vite Plugin
- **QA & DX:** Pest, Laravel Pint, Laravel Boost, Pail

## Requirements
- PHP 8.2+, Composer 2.x
- Node.js 20+ and npm
- MySQL/MariaDB
- Redis (for cache/queues)

## Getting Started
1) Copy environment template:
	```bash
	cp .env.example .env
	```
2) Install backend deps and app key:
	```bash
	composer install
	php artisan key:generate
	```
3) Configure `.env` (DB, Redis, Mailgun, AWS S3 credentials).
4) Run migrations (and seeds if needed):
	```bash
	php artisan migrate --force
	# php artisan db:seed
	```
5) Install frontend deps and start Vite:
	```bash
	npm install
	npm run dev   # HMR; use npm run build for production assets
	```
6) Start app and queues locally:
	```bash
	php artisan serve
	php artisan queue:listen --tries=1
	```
	Or run everything at once: `composer dev` (server, queues, pail logs, Vite via concurrently).

## Available Scripts
- `composer dev` — run server, queues, logs, and Vite together
- `composer test` — run Pest test suite
- `./vendor/bin/pint` — format PHP code
- `npm run dev` — Vite dev server (HMR)
- `npm run build` — production assets

## Deployment Notes
- Build frontend: `npm run build`
- Cache config/routes: `php artisan config:cache && php artisan route:cache`
- Run queue worker: `php artisan queue:work --tries=3`

## Handy Paths
- Config: `config/`
- Controllers: `app/Http/Controllers`
- Actions/Domain: `app/Actions`
- Models: `app/Models`
- Tests: `tests/`
