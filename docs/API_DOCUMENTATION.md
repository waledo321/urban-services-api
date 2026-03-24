# Urban Services API Documentation

## Base URL
- Local: `http://127.0.0.1:8000`
- API Prefix: `/api/v1`

## Authentication
This API uses **Laravel Sanctum** Bearer tokens.

1. Call `POST /api/v1/login`
2. Copy `data.token`
3. Send header in protected requests:
   - `Authorization: Bearer <token>`

To logout and revoke current token:
- `POST /api/v1/logout`

## Unified Response Contract
All endpoints return the same envelope:

```json
{
  "success": true,
  "message": "Human-readable message",
  "data": {},
  "errors": null
}
```

Error example:

```json
{
  "success": false,
  "message": "Validation failed.",
  "data": null,
  "errors": {
    "field": ["The field is required."]
  }
}
```

## Status Codes
- `200` OK
- `201` Created
- `401` Unauthenticated
- `404` Resource not found
- `422` Validation failed
- `500` Internal server error

## Auth Endpoints

### POST `/api/v1/login`
Request body:

```json
{
  "email": "tester@example.com",
  "password": "password",
  "device_name": "flutter-app"
}
```

Success response data shape:

```json
{
  "token": "plain_text_token",
  "token_type": "Bearer",
  "user": {
    "id": 1,
    "name": "Test User",
    "email": "tester@example.com"
  }
}
```

### POST `/api/v1/logout`
- Protected by `auth:sanctum`
- Revokes current token

## Protected Resources
All routes below require Bearer token:

- `buildings`
- `apartments`
- `families`
- `shops`
- `graves`
- `complaints`

Each resource supports full REST actions:
- `GET /api/v1/{resource}` (index)
- `POST /api/v1/{resource}` (store)
- `GET /api/v1/{resource}/{id}` (show)
- `PUT /api/v1/{resource}/{id}` (update)
- `DELETE /api/v1/{resource}/{id}` (destroy)

## Minimal Request Payload Samples

### Building (POST `/api/v1/buildings`)
```json
{
  "name": "Al Noor Building",
  "real_estate_number": "RE-1001",
  "license_number": "LIC-2026-01",
  "total_floors": 5,
  "has_basement": true,
  "has_garage": true,
  "ownership_type": "private",
  "is_illegal": false,
  "coordinates": {
    "lat": 33.3152,
    "lng": 44.3661
  }
}
```

### Apartment (POST `/api/v1/apartments`)
```json
{
  "building_id": 1,
  "floor_type": "residential",
  "water_meter": "WM-001",
  "electricity_meter": "EM-001",
  "landline": "123456789",
  "is_sealed": false
}
```

### Family (POST `/api/v1/families`)
```json
{
  "apartment_id": 1,
  "family_book": "FB-1001",
  "health_status": "good",
  "living_status": "resident",
  "last_aid_date": "2026-03-01",
  "unemployed_count": 1,
  "students_count": 2,
  "occupancy_type": "owner"
}
```

### Shop (POST `/api/v1/shops`)
```json
{
  "building_id": 1,
  "owner_family_id": 1,
  "profession": "grocery",
  "occupancy_type": "rent"
}
```

### Grave (POST `/api/v1/graves`)
```json
{
  "family_id": 1,
  "block_name": "A",
  "row_number": 12,
  "status": "available"
}
```

### Complaint (POST `/api/v1/complaints`)
```json
{
  "family_id": 1,
  "description": "Water leakage in apartment",
  "ai_category": "infrastructure",
  "priority": "high",
  "status": "pending"
}
```

## Frontend Integration Notes
- Save token securely on device (Flutter secure storage recommended).
- Attach Bearer token to every protected API request.
- Build UI error handling using `success`, `message`, and `errors` keys.
- For list pages, use `data` directly (resource collection payload).