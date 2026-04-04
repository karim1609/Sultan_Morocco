# Sultan Morocco

A **Laravel** web application for discovering Morocco: hotel listings (via a proxied third-party API), an interactive map, user authentication, profiles, and **direct messaging** between registered users. The UI uses **Blade**, **Tailwind CSS v4**, and **Vite**, with a manual light/dark theme.

---

## Table of contents

1. [Requirements](#requirements)
2. [Quick start](#quick-start)
3. [Environment variables](#environment-variables)
4. [Project structure](#project-structure)
5. [Features](#features)
6. [HTTP routes](#http-routes)
7. [Hotel API (Xotelo proxy)](#hotel-api-xotelo-proxy)
8. [Database schema](#database-schema)
9. [Eloquent models](#eloquent-models)
10. [Front-end assets](#front-end-assets)
11. [Theme system](#theme-system)
12. [Navigation component](#navigation-component)
13. [Security notes](#security-notes)
14. [Development commands](#development-commands)
15. [Testing](#testing)
16. [Deployment checklist](#deployment-checklist)

---

## Requirements

| Component | Version / notes |
|-----------|------------------|
| PHP | **^8.3** |
| Composer | Latest |
| Node.js + npm | For Vite / Tailwind build |
| Database | SQLite (default in `.env.example`) or MySQL/PostgreSQL |
| Extensions | Typical Laravel set (`openssl`, `pdo`, `mbstring`, `tokenizer`, `xml`, `ctype`, `json`, `fileinfo`) |

Framework: **Laravel 13**.

---

## Quick start

From the `Sultan_Morocco` directory:

```bash
composer run setup
```

Or manually:

```bash
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate
npm install
npm run build
php artisan serve
```

For day-to-day development (server + Vite + queue + logs):

```bash
composer run dev
```

Configure **`XOTELO_LOCATION_KEY`** in `.env` if you need hotel listing and map data (see [Hotel API](#hotel-api-xotelo-proxy)).

---

## Environment variables

Copy `.env.example` to `.env`. Important keys:

| Variable | Purpose |
|----------|---------|
| `APP_NAME`, `APP_URL`, `APP_KEY` | Laravel application identity and encryption |
| `APP_DEBUG` | Set `false` in production |
| `DB_*` | Database connection (default example uses SQLite) |
| `SESSION_DRIVER` | Often `database` (requires `sessions` table — included in default user migration) |
| `XOTELO_BASE_URL` | Xotelo API base (default `https://data.xotelo.com/api`) |
| `XOTELO_LOCATION_KEY` | **Required** for `/api/hotels`; geography key from Xotelo for your region. **Do not commit real values** — keep them only in `.env`. |

Never commit `.env`. `.env.example` is safe to commit with empty placeholders.

---

## Project structure

```
Sultan_Morocco/
├── app/
│   ├── Http/Controllers/
│   │   ├── AuthController.php      # Login, signup, logout
│   │   ├── HotelController.php     # Hotels page + JSON proxy
│   │   └── MessageController.php   # Inbox, thread, send, open-by-user-id
│   ├── Models/                     # Eloquent models
│   └── Providers/AppServiceProvider.php
├── bootstrap/app.php               # App bootstrap, route registration
├── config/                         # Laravel config (includes services.xotelo)
├── database/migrations/            # Schema definitions
├── public/                         # Web root (index.php, assets)
├── resources/
│   ├── css/app.css                 # Tailwind + custom utilities
│   ├── js/
│   │   ├── app.js                  # Entry (bootstrap, theme, navbar)
│   │   ├── bootstrap.js
│   │   ├── theme.js                # Light/dark toggle + localStorage
│   │   └── navbar.js               # Master nav scroll + mobile drawer
│   └── views/                      # Blade templates + components
├── routes/web.php                  # All web routes (no api.php in use)
├── tests/                          # PHPUnit
├── composer.json
├── package.json
└── vite.config.js
```

---

## Features

### Public

- **Welcome** (`/`) — Marketing-style landing page with navigation to Map, Hotels, auth.
- **Hotels** (`/hotels`) — Client-side loaded grid; fetches JSON from **`GET /api/hotels`**.
- **Map** (`/map`) — Leaflet map + sidebar list; same **`/api/hotels`** endpoint with pagination/sort.

### Guest only (`guest` middleware)

- **Login** — `GET/POST /login`
- **Signup** — `GET/POST /signup` (password min 8 chars, must match `confirm_password`)

### Authenticated (`auth` middleware)

- **Logout** — `GET/POST /logout` (session invalidated, CSRF on POST)
- **Profile** — `GET /profile/{id}` — shows user by ID; includes “Message” for other users.
- **Messages**
  - Inbox: `GET /messages`
  - Open thread by user: `GET /messages/{user}` (route model binding on `User`)
  - Send: `POST /messages/{user}` (field: `body`, max 5000 chars)
  - Open by numeric ID: `POST /messages/by-user-id` (field: `user_id`)

### UI / UX

- **Master navbar** (`resources/views/components/navbar.blade.php`) — Primary links (Home, Map, Hotels, Messages when logged in), theme toggle, auth-aware actions, mobile drawer (`resources/js/navbar.js`), scroll-compact behavior.
- **Chat layout** — `resources/views/components/layouts/chat.blade.php` + `variant="chat"` on navbar for dark conversation pages.
- **Theme** — `resources/js/theme.js`, `x-theme-init`, `x-theme-toggle`; persistence key `sultan-theme` in `localStorage`.

---

## HTTP routes

| Method | URI | Name | Middleware | Description |
|--------|-----|------|------------|-------------|
| GET | `/` | — | web | Welcome |
| GET | `/login` | `login` | guest | Login form |
| POST | `/login` | — | guest | Login |
| GET | `/signup` | `signup` | guest | Signup form |
| POST | `/signup` | — | guest | Register |
| GET | `/logout` | `logout` | auth | Logout |
| POST | `/logout` | — | auth | Logout |
| GET | `/hotels` | `hotels.index` | web | Hotels Blade page |
| GET | `/api/hotels` | `hotels.list` | web | JSON hotel list (proxy) |
| GET | `/map` | `map.index` | web | Map Blade page |
| GET | `/profile/{id}` | `profile` | auth | User profile |
| GET | `/messages` | `messages.index` | auth | Inbox |
| POST | `/messages/by-user-id` | `messages.by_user_id` | auth | Redirect to thread |
| GET | `/messages/{user}` | `messages.show` | auth | Thread |
| POST | `/messages/{user}` | `messages.store` | auth | Send message |

Health check (framework default): **`GET /up`**.

---

## Hotel API (Xotelo proxy)

The browser never calls Xotelo directly with your location key. Laravel proxies:

**Upstream:** `GET {XOTELO_BASE_URL}/list`  
**Query parameters sent to Xotelo:**

| Parameter | Source | Default / validation |
|-----------|--------|----------------------|
| `location_key` | `config('services.xotelo.location_key')` from `XOTELO_LOCATION_KEY` | **Required** — if empty, API returns **503** JSON |
| `offset` | Client query | default `0`, integer ≥ 0 |
| `limit` | Client query | default `30`, 1–100 |
| `sort` | Client query | `best_value` (default), `popularity`, or `distance` |

**Success:** HTTP 200, `Content-Type: application/json`, body is Xotelo’s JSON (pass-through).  
**Upstream failure:** HTTP 502 with `{ "error": { "message": "..." }, "result": null }`.  
**Not configured:** HTTP 503 if `XOTELO_LOCATION_KEY` is missing.

**TLS:** In non-production environments only, the HTTP client may use `withoutVerifying()` for local TLS/CA issues; production should verify certificates normally.

Implementation: `App\Http\Controllers\HotelController::list`.  
Configuration: `config/services.php` → `xotelo`.

---

## Database schema

Defined in `database/migrations/` (run in chronological order).

### Users & session (Laravel defaults)

- **`users`** — `name`, `email`, `password`, `email_verified_at`, `avatar`, `role` (`user`|`admin`|`author`), `country`, `remember_token`, timestamps.
- **`password_reset_tokens`**, **`sessions`** — framework tables.

### Domain tables (present in migrations; not all wired to UI)

| Table | Purpose |
|-------|---------|
| **`places`** | POIs: type, description, address, city, country, lat/lng, price_level, rating, image |
| **`reviews`** | `user_id`, `place_id`, `rating`, `comment`, optional `image` |
| **`favorites`** | Unique `(user_id, place_id)` |
| **`itineraries`** | `user_id`, `name`, `start_date`, `end_date` |
| **`itinerary_items`** | `itinerary_id`, `place_id`, `day`, `order` |
| **`notifications`** | `user_id`, `title`, `body`, `is_read` |

### Messaging (direct chat)

| Table | Purpose |
|-------|---------|
| **`conversations`** | Thread metadata: `last_message_at`, `last_message_preview` |
| **`conversation_user`** | Pivot: `conversation_id`, `user_id` (unique pair per row) |
| **`messages`** | `conversation_id`, `sender_id`, `body`, `read_at` |

Note: An older **`chat_messages`** migration may exist in history; a later migration **drops** it and replaces the feature with the tables above.

---

## Eloquent models

| Model | Main relationships / notes |
|-------|----------------------------|
| `User` | `hasMany` reviews, favorites, itineraries, sentMessages, notifications; `belongsToMany` conversations |
| `Conversation` | `belongsToMany` users; `hasMany` messages; `findOrCreateDirectBetween()` for 1:1 threads |
| `Message` | `belongsTo` conversation, sender (User) |
| `Place`, `Review`, `Favorite`, `Itinerary`, `ItineraryItem`, `Notification` | Match migrations; use when you build features on top |

---

## Front-end assets

- **Vite** bundles `resources/css/app.css` and `resources/js/app.js`.
- **Tailwind CSS v4** via `@tailwindcss/vite`.
- **Hotels** and **Map** pages embed substantial inline JavaScript in Blade for listing, Leaflet markers, and `fetch('/api/hotels?...')`.

Build production assets:

```bash
npm run build
```

---

## Theme system

- **`resources/js/theme.js`** — Reads/writes `localStorage` key `sultan-theme` (`light` | `dark`); falls back to `prefers-color-scheme`.
- Applies `dark` class and `data-theme` on `<html>`.
- **`@custom-variant dark`** in `app.css` targets `.dark` and `[data-theme='dark']`.

---

## Navigation component

`<x-navbar />` optional props:

- **`variant`** — `default` | `chat` (dark styling for chat layout).

Optional **slots** (for extending without forking):

- **`extraNav`** — Extra center links (desktop).
- **`beforeActions`** — Before theme toggle / auth cluster.
- **`actions`** — After auth buttons.
- **`mobileExtra`** — Extra block in mobile drawer.

---

## Security notes

- **Sessions** — Auth uses Laravel session guard; regenerate on login; invalidate on logout.
- **CSRF** — Forms include `@csrf`; AJAX to same-origin web routes should send `X-CSRF-TOKEN` if you add SPA-style calls.
- **Messaging** — Users only see conversations they participate in; `sender_id` set server-side; Blade escapes message bodies (`{{ }}`).
- **Hotel proxy** — Hides `XOTELO_LOCATION_KEY` from the browser; validate query params server-side (already done).
- **Profile** — Any authenticated user can view `/profile/{id}` by ID (consider privacy rules later).
- **Secrets** — Keep `.env` out of Git; use host env vars in production.

---

## Development commands

| Command | Description |
|---------|-------------|
| `php artisan serve` | Local HTTP server |
| `npm run dev` | Vite dev server + HMR |
| `composer run dev` | Concurrent: `serve`, queue worker, `pail`, `npm run dev` |
| `vendor/bin/pint` | PHP code style (Laravel Pint) |
| `php artisan test` | PHPUnit |

---

## Testing

```bash
php artisan test
```

Default tests live under `tests/`. Add feature tests for auth, hotel proxy, and messaging as the app grows.

---

## Deployment checklist

1. Set `APP_ENV=production`, `APP_DEBUG=false`, strong `APP_KEY`.
2. Run `composer install --no-dev --optimize-autoloader`.
3. Run `npm ci && npm run build` (or build assets in CI and deploy `public/build`).
4. Run `php artisan migrate --force`.
5. Set **`XOTELO_LOCATION_KEY`** (and database credentials) in the server environment — not in the repo.
6. Ensure PHP can verify TLS to `data.xotelo.com` in production (do not rely on `withoutVerifying()`).
7. Configure web server document root to **`public/`**.
8. Optional: `php artisan config:cache` `route:cache` `view:cache`.

---

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT). This project’s `composer.json` inherits that skeleton; add your own project license if you redistribute.

---

## Attribution

Hotel listing data is proxied from **[Xotelo](https://xotelo.com)** (see in-app footer on hotels/map). Respect their terms of use and rate limits when operating in production.
