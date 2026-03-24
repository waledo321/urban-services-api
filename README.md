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

## API Handoff for Frontend

- Full API docs: `docs/API_DOCUMENTATION.md`
- Postman collection: `postman/Urban-Services-API.postman_collection.json`
- Postman environment: `postman/Urban-Services-Local.postman_environment.json`

## Postman Setup Steps

1. Import collection file.
2. Import environment file.
3. Select `Urban Services API - Local` environment.
4. Run `Auth > Login` first (token auto-saved to `{{token}}`).
5. Call protected endpoints.

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