# Sultan Morocco

A **Laravel 13** web application for discovering Morocco: curated **hotel** and **restaurant** listings, an interactive **map**, a travel **chatbot**, session **authentication**, user **profiles**, and **direct messaging** between users.

The UI uses **Blade**, **Tailwind CSS v4**, and **Vite**, with a manual light/dark theme.

> **Repository layout:** the runnable application is in [`Sultan_Morocco/`](Sultan_Morocco/). Run all commands from that directory unless noted otherwise.

---

## Table of contents

1. [What this app does](#what-this-app-does)
2. [Tech stack](#tech-stack)
3. [Requirements](#requirements)
4. [Quick start](#quick-start)
5. [Environment variables](#environment-variables)
6. [Where data comes from](#where-data-comes-from)
7. [Project structure](#project-structure)
8. [Features](#features)
9. [HTTP routes](#http-routes)
10. [JSON APIs](#json-apis)
11. [Chatbot](#chatbot)
12. [Authentication & messaging](#authentication--messaging)
13. [Database](#database)
14. [Front-end](#front-end)
15. [Editing listings](#editing-listings)
16. [Seeding demo users](#seeding-demo-users)
17. [Development commands](#development-commands)
18. [Testing](#testing)
19. [Deployment](#deployment)
20. [Roadmap & unused schema](#roadmap--unused-schema)

---

## What this app does

| Area | Behavior |
|------|----------|
| **Hotels** | ~30 Morocco hotels served as JSON from a static PHP array (`HotelController`). The hotels page and map fetch `/api/hotels`. |
| **Restaurants** | 15 curated restaurants from a static array (`RestaurantController`). Page can use Blade data and/or `/api/restaurants`. |
| **Map** | Leaflet map with markers from the hotels API; reverse-geocoded addresses via Nominatim in the browser. |
| **Chatbot** | Floating widget on welcome, hotels, restaurants, and map. Rule-based answers for common travel intents; optional OpenAI for other questions. |
| **Auth** | Email/password signup and login (Laravel session guard). |
| **Messages** | Authenticated 1:1 direct messages stored in `conversations` / `messages` tables. |
| **Profile** | View any user by ID when logged in; link to start a message thread. |

There is **no live hotel/restaurant listing API** (no Xotelo or TripAdvisor API integration at runtime). Listings are **bundled in the codebase**.

---

## Tech stack

| Layer | Technology |
|-------|------------|
| Backend | PHP **^8.3**, Laravel **^13** |
| Database | SQLite by default (MySQL/PostgreSQL supported) |
| Front-end build | Vite **^8**, Tailwind CSS **^4** (`@tailwindcss/vite`) |
| HTTP client (server) | Laravel HTTP → OpenAI (chatbot only, optional) |
| Map (browser) | Leaflet 1.9 + MarkerCluster (CDN) |
| Geocoding (browser) | [Nominatim](https://nominatim.openstreetmap.org) reverse API |

---

## Requirements

| Component | Notes |
|-----------|--------|
| PHP | **8.3+** with extensions: `openssl`, `pdo`, `mbstring`, `tokenizer`, `xml`, `ctype`, `json`, `fileinfo` |
| Composer | Latest stable |
| Node.js + npm | **18+** recommended (Vite 8) |

---

## Quick start

```bash
cd Sultan_Morocco
composer run setup
php artisan serve
```

Open **http://127.0.0.1:8000**. Hotels, restaurants, and the map work without any API keys.

### What `composer run setup` does

1. `composer install`
2. Copies `.env.example` → `.env` if missing
3. Creates `database/database.sqlite` if using default SQLite
4. `php artisan key:generate`
5. `php artisan migrate --force`
6. `npm install` && `npm run build`

### Manual setup

```bash
cd Sultan_Morocco
cp .env.example .env          # Windows: copy .env.example .env
composer install
php artisan key:generate
touch database/database.sqlite   # skip if using MySQL/PostgreSQL
php artisan migrate
npm install
npm run build
php artisan serve
```

### Day-to-day development

Runs HTTP server, queue worker, log tail (`pail`), and Vite HMR together:

```bash
composer run dev
```

---

## Environment variables

Copy `.env.example` to `.env`.

| Variable | Required? | Purpose |
|----------|-----------|---------|
| `APP_KEY` | Yes (after `key:generate`) | Encryption & sessions |
| `APP_URL` | Yes | Base URL (e.g. `http://127.0.0.1:8000`) |
| `DB_*` | Yes | Default: `DB_CONNECTION=sqlite` + `database/database.sqlite` |
| `SESSION_DRIVER` | — | Default `database` (needs `sessions` table from migrations) |
| `QUEUE_CONNECTION` | — | Default `database` (used by `composer run dev`) |
| `CACHE_STORE` | — | Default `database` |
| `OPENAI_API_KEY` | **Optional** | Smarter chatbot replies; rule-based mode works without it |

Never commit `.env`.

---

## Where data comes from

Understanding the footer and runtime behavior:

| Source | What it provides | When |
|--------|------------------|------|
| **`HotelController` / `RestaurantController`** | Names, ratings, prices, coordinates, TripAdvisor URLs, image URLs | Every page load via `/api/hotels` or `/api/restaurants` (or Blade for restaurants index) |
| **TripAdvisor** | Links and CDN image URLs **embedded in the PHP arrays** | Not an API call — data was curated into the repo; images load from `tripadvisor.com` / `dynamic-media-cdn.tripadvisor.com` in the browser |
| **Unsplash** | Some restaurant photos | Static URLs in `RestaurantController` |
| **Nominatim (OpenStreetMap)** | Street-level address lines on hotel cards and map sidebar | Browser `fetch` to `nominatim.openstreetmap.org/reverse` using each hotel’s lat/lon (~1 request / 1.15s) |
| **OpenStreetMap + CARTO** | Map tiles | Leaflet on `/map` |
| **OpenAI** | Free-form chatbot answers | Only when the user’s message does not match a rule intent **and** `OPENAI_API_KEY` is set |

**Database** is used for **users**, **sessions**, **cache**, **jobs**, and **direct messaging** — not for hotel/restaurant listings.

---

## Project structure

```
Sultan_Morocco/
├── app/
│   ├── Http/Controllers/
│   │   ├── AuthController.php         # Login, signup, logout
│   │   ├── HotelController.php        # Static hotels + GET /api/hotels
│   │   ├── RestaurantController.php   # Static restaurants + GET /api/restaurants
│   │   ├── ChatController.php         # POST /api/chat (rules + optional OpenAI)
│   │   └── MessageController.php      # Inbox & direct threads
│   └── Models/                        # User, Conversation, Message, Place, …
├── bootstrap/app.php                  # Routes: web.php, console.php, health /up
├── config/                            # Laravel config; services.openai
├── database/
│   ├── migrations/
│   ├── factories/UserFactory.php
│   └── seeders/DatabaseSeeder.php     # 200 fake users (optional)
├── public/                            # Web root → point vhost here
├── resources/
│   ├── css/app.css
│   ├── js/                            # app.js, theme.js, navbar.js
│   └── views/                         # Blade pages & components
├── routes/web.php                     # All application routes
├── tests/
├── composer.json
├── package.json
└── vite.config.js
```

---

## Features

### Public (no login)

- **Home** (`/`) — Landing page, category links, chatbot.
- **Hotels** (`/hotels`) — Paginated grid, city filters, sort; loads `/api/hotels`.
- **Restaurants** (`/restaurants`) — Filter by city; static data + optional API refresh.
- **Map** (`/map`) — Leaflet map, hotel markers, sidebar list.
- **Chatbot** — `POST /api/chat` (no auth, not persisted).

### Guest only

- **Login** / **Signup** — Session-based auth; password min 8 chars, must match `confirm_password` on signup.

### Authenticated

- **Logout** — `GET` or `POST` `/logout`
- **Profile** — `GET /profile/{id}`
- **Messages** — Inbox, thread with another user, send text (max 5000 chars), open thread by user ID

### UI

- Global **navbar** with Home, Map, Hotels, Restaurants, Messages (when logged in), theme toggle, mobile drawer.
- **Light/dark theme** — `localStorage` key `sultan-theme`.
- **Chat layout** — Dark navbar variant on message threads.

---

## HTTP routes

| Method | URI | Name | Middleware | Handler |
|--------|-----|------|------------|---------|
| GET | `/` | — | web | `welcome` |
| GET | `/login` | `login` | guest | `AuthController@showLogin` |
| POST | `/login` | — | guest | `AuthController@login` |
| GET | `/signup` | `signup` | guest | `AuthController@showSignup` |
| POST | `/signup` | — | guest | `AuthController@signup` |
| GET/POST | `/logout` | `logout` | auth | `AuthController@logout` |
| GET | `/hotels` | `hotels.index` | web | `HotelController@index` |
| GET | `/api/hotels` | `hotels.list` | web | `HotelController@list` |
| GET | `/restaurants` | `restaurants.index` | web | `RestaurantController@index` |
| GET | `/api/restaurants` | `restaurants.list` | web | `RestaurantController@list` |
| POST | `/api/chat` | `chat` | web | `ChatController@chat` |
| GET | `/map` | `map.index` | web | `map.index` |
| GET | `/profile/{id}` | `profile` | auth | User profile view |
| GET | `/messages` | `messages.index` | auth | Inbox |
| POST | `/messages/by-user-id` | `messages.by_user_id` | auth | Open thread by `user_id` |
| GET | `/messages/{user}` | `messages.show` | auth | Thread (route model binding) |
| POST | `/messages/{user}` | `messages.store` | auth | Send message (`body`) |

**Health check:** `GET /up` (Laravel default).

---

## JSON APIs

### `GET /api/hotels`

**Controller:** `HotelController::list`  
**Data:** static `$HOTELS` array (~30 entries).

| Query | Default | Notes |
|-------|---------|-------|
| `offset` | `0` | Integer ≥ 0 |
| `limit` | `30` | 1–100 |
| `sort` | `best_value` | `best_value` (rating, then review count) or `popularity` (review count) |

**Response:**

```json
{
  "error": null,
  "result": {
    "total_count": 30,
    "limit": 30,
    "offset": 0,
    "list": [ { "name": "...", "geo": { "latitude": 31.62, "longitude": -7.98 }, "url": "https://www.tripadvisor.com/...", ... } ]
  }
}
```

Each item includes `name`, `key`, `accommodation_type`, `url`, `review_summary`, `price_ranges`, `geo`, `image`, `merchandising_labels`.

### `GET /api/restaurants`

**Controller:** `RestaurantController::list`  
**Data:** static `$RESTAURANTS` array (15 entries).

| Query | Default | Notes |
|-------|---------|-------|
| `city` | — | Filter by city name (omit or `all` for all) |
| `sort` | `rating` | `rating`, `price_asc`, or `price_desc` |

**Response:**

```json
{
  "error": null,
  "result": {
    "total_count": 15,
    "list": [ { "name": "...", "city": "Marrakech", "tripadvisor_url": "...", ... } ]
  }
}
```

---

## Chatbot

**Endpoint:** `POST /api/chat`  
**Body:** `{ "message": "your text" }`  
**Auth:** none  
**Persistence:** none (not stored in DB)

1. **Rule engine** — Keyword intents: `greeting`, `help`, `restaurants`, `hotels`, `surf`, `itinerary`, `weather`. Returns JSON with `type`: `text`, `buttons`, or `cards`.
2. **OpenAI fallback** — If no intent matches and `OPENAI_API_KEY` is set, calls `gpt-4o-mini`. If the key is missing, returns a friendly default with suggestion buttons.

Implementation: `App\Http\Controllers\ChatController`.

---

## Authentication & messaging

### Authentication

- Laravel **session** guard (`Auth::attempt`, `Auth::login`, `Auth::logout`).
- On login: session regenerated. On logout: session invalidated + CSRF token rotated.
- Signup fields: `name`, `email` (unique), `password` (+ `confirm_password`).

### Direct messaging

- **1:1 threads** via `conversations` + `conversation_user` pivot.
- `Conversation::findOrCreateDirectBetween($userA, $userB)` — reuses existing two-user thread or creates one.
- Cannot message yourself (403).
- Inbox sorted by `last_message_at`; unread = messages from the other participant with `read_at` null.
- Opening a thread marks the other user’s messages as read.
- Message bodies escaped in Blade (`{{ }}`).

---

## Database

Run migrations:

```bash
php artisan migrate
```

### Tables in use

| Table | Purpose |
|-------|---------|
| `users` | Accounts (`name`, `email`, `password`, optional `avatar`, `role`, `country`) |
| `sessions` | Session storage when `SESSION_DRIVER=database` |
| `cache`, `cache_locks` | Cache when `CACHE_STORE=database` |
| `jobs`, `job_batches`, `failed_jobs` | Queue when `QUEUE_CONNECTION=database` |
| `conversations`, `conversation_user`, `messages` | Direct messaging |

### Schema present but not used in UI

These migrations exist for future features; **no controllers or pages use them today**:

| Table | Intended purpose |
|-------|------------------|
| `places` | POIs (hotel, restaurant, bar, gym, attraction) |
| `reviews`, `favorites` | User ↔ place interactions |
| `itineraries`, `itinerary_items` | Trip planning |
| `notifications` | In-app notifications |

Legacy `chat_messages` was created then **dropped** in favor of direct messaging (`2026_04_04_120000_replace_chat_with_direct_messaging_tables`).

### Eloquent models

| Model | Used by app |
|-------|-------------|
| `User`, `Conversation`, `Message` | Yes — auth, profile, messaging |
| `Place`, `Review`, `Favorite`, `Itinerary`, `ItineraryItem`, `Notification` | Models only — awaiting features |

---

## Front-end

### Vite bundle

- **Entries:** `resources/css/app.css`, `resources/js/app.js`
- **`app.js`** imports `bootstrap.js` (axios), `theme.js`, `navbar.js`
- Included via `@vite(...)` in `components/layouts/app.blade.php` and `layouts/auth.blade.php`

### Key Blade components

| Component | Role |
|-----------|------|
| `components/navbar.blade.php` | Global navigation (`variant`: `default` \| `chat`) |
| `components/chatbot.blade.php` | Floating Sultan assistant |
| `components/layouts/app.blade.php` | Main layout |
| `components/layouts/chat.blade.php` | Messaging layout |
| `components/theme-init.blade.php`, `theme-toggle.blade.php` | Theme |
| `components/alert.blade.php` | Flash messages |

### Pages with heavy inline JavaScript

| View | Notes |
|------|-------|
| `hotels/index.blade.php` | Fetches `/api/hotels`, Nominatim address queue, pagination |
| `restaurants/index.blade.php` | Filters; may call `/api/restaurants` |
| `map/index.blade.php` | Leaflet, `/api/hotels`, Nominatim, marker clustering |

**Chatbot** appears on: welcome, hotels, restaurants, map.

### Theme

- Key: `sultan-theme` (`light` \| `dark`) in `localStorage`
- `resources/js/theme.js` sets `dark` class and `data-theme` on `<html>`
- Tailwind dark variant in `app.css` targets `.dark` and `[data-theme='dark']`

---

## Editing listings

To add or change hotels or restaurants, edit the private arrays in:

- `app/Http/Controllers/HotelController.php` → `$HOTELS`
- `app/Http/Controllers/RestaurantController.php` → `$RESTAURANTS`

No migration or admin panel is required. After edits, refresh the page (rebuild assets only if you changed CSS/JS).

---

## Seeding demo users

Optional — creates **200** fake users for testing profiles and messaging:

```bash
php artisan db:seed
```

Does not seed hotels, restaurants, or conversations.

---

## Development commands

| Command | Description |
|---------|-------------|
| `composer run setup` | First-time install + migrate + build |
| `composer run dev` | `serve` + `queue:listen` + `pail` + `npm run dev` |
| `composer run test` | Clear config cache + PHPUnit |
| `php artisan serve` | Local server |
| `npm run dev` | Vite HMR only |
| `npm run build` | Production assets → `public/build` |
| `vendor/bin/pint` | Laravel Pint (code style) |

---

## Testing

```bash
php artisan test
```

| File | Coverage |
|------|----------|
| `tests/Feature/ExampleTest.php` | `GET /` returns 200 |
| `tests/Unit/ExampleTest.php` | Placeholder |

PHPUnit uses in-memory SQLite per `phpunit.xml`. Add tests for auth, APIs, and messaging as the app grows.

---

## Deployment

1. Set `APP_ENV=production`, `APP_DEBUG=false`, strong `APP_KEY`.
2. `composer install --no-dev --optimize-autoloader`
3. `npm ci && npm run build`
4. `php artisan migrate --force`
5. Configure `DB_*` and optional `OPENAI_API_KEY` on the server (not in Git).
6. Point the web server document root to **`public/`**.
7. Optional: `php artisan config:cache`, `route:cache`, `view:cache`

Respect [Nominatim usage policy](https://operations.osmfoundation.org/policies/nominatim/) if traffic grows (rate-limit reverse geocoding in production).

---

## Roadmap & unused schema

| Item | Status |
|------|--------|
| Places, reviews, favorites, itineraries in DB | Migrations + models only |
| `users.role` (`user` \| `admin` \| `author`) | Column exists; not enforced in UI |
| Email verification | Column on `users`; not implemented on signup |
| `database/seeders/reviews.php` | Orphan seeder (not wired; no `ReviewFactory`) |
| `docs/application.xml`, `docs/*.drawio` | May still mention removed Xotelo integration — treat as stale |

---

## Technical report (LaTeX / Overleaf)

An ultra-detailed French technical report with **PDF animations** (TikZ), architecture diagrams, and screenshot placeholders is in:

**[`Sultan_Morocco/docs/overleaf-rapport/`](Sultan_Morocco/docs/overleaf-rapport/)**

Upload that folder as a ZIP to [Overleaf](https://www.overleaf.com) and compile `main.tex` with **pdfLaTeX**. See `README-OVERLEAF.md` inside for instructions.

---

## License & attribution

Laravel is [MIT licensed](https://opensource.org/licenses/MIT).

**Content attribution:**

- Hotel and restaurant **listings** — curated static data in this repository.
- **TripAdvisor** — reference URLs and image CDN links in listing records.
- **OpenStreetMap / Nominatim** — live reverse geocoding for display addresses.
- **OpenAI** — optional chatbot fallback when configured.
