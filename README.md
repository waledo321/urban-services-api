# Urban Services API (Backend)

This project is a Laravel API backend for a Smart Urban Services Management Platform.

## Quick Start

1. Install dependencies:
   - `composer install`
2. Configure `.env` and database credentials.
3. Generate app key:
   - `php artisan key:generate`
4. Run migrations:
   - `php artisan migrate`
5. Start local server:
   - `php artisan serve`

## Troubleshooting

### `php artisan optimize:clear` fails on cache (MySQL “connection refused”)

That happens when `CACHE_STORE=database` but MySQL is not running. Either **start MySQL** (e.g. XAMPP), or set **`CACHE_STORE=file`** in `.env` (recommended for local dev; this repo’s `.env.example` defaults that way).

## API Handoff for Frontend

- Full API docs: `docs/API_DOCUMENTATION.md`
- Postman collection: `postman/Urban-Services-API.postman_collection.json`
- Postman environment: `postman/Urban-Services-Local.postman_environment.json`

## Postman Setup Steps

1. Import collection file.
2. Import environment file.
3. Select `Urban Services API - Local` environment.
4. Run `Auth > Login` first (token auto-saved to `{{token}}`).
5. Run any `Create *` request first in each resource folder (new ID auto-saved to environment variables like `{{buildingId}}`, `{{familyId}}`).
6. Use `Auth > Login Invalid Credentials` to quickly verify the unified error envelope behavior.
7. Call remaining protected endpoints.

## Authentication

- Uses Laravel Sanctum Bearer token.
- Public route: `POST /api/v1/login`
- Protected routes: all resource routes + `POST /api/v1/logout`

## Unified API Response

All responses follow this structure:

```json
{
  "success": true,
  "message": "...",
  "data": {},
  "errors": null
}
```