# Backend Architecture

## Module Layout

Backend modules live under `app/Modules`. User-related bounded contexts are grouped in `app/Modules/User`.

```text
app/Modules/User/
├── Auth/
│   ├── Domain/
│   ├── Application/
│   │   ├── Commands/
│   │   ├── Handlers/
│   │   ├── Queries/
│   │   ├── QueryHandlers/
│   │   └── DTOs/
│   ├── Infrastructure/
│   │   └── Pipelines/
│   ├── Presentation/
│   │   └── Http/
│   │       ├── Controllers/
│   │       └── Requests/
│   └── Support/
└── Profile/
    ├── Domain/
    ├── Application/
    │   ├── Commands/
    │   ├── Handlers/
    │   ├── Queries/
    │   ├── QueryHandlers/
    │   └── DTOs/
    ├── Infrastructure/
    ├── Presentation/
    │   └── Http/
    │       ├── Controllers/
    │       └── Requests/
    └── Support/
```

Empty layer directories are created when the module needs that responsibility.

## CQRS Rules

- HTTP controllers are thin. They convert a request to a command/query, call a handler, and return `ApiResponse`.
- Write operations use `Application/Commands` and `Application/Handlers`.
- Read operations use `Application/Queries`, `Application/QueryHandlers`, and `Application/DTOs`.
- Business steps with multiple sequential operations use Laravel Pipeline classes in `Infrastructure/Pipelines`.
- Output data is returned through DTO objects. Eloquent models should not be exposed directly from handlers.

## Requests

All Form Requests extend `App\Http\Requests\BaseFormRequest`.

Every request implements `toCommand()` when it represents a write operation. Controllers must not manually assemble command payloads.

Validation errors are returned through `ApiResponse::validationError()` with this shape:

```json
{
  "success": false,
  "message": "Validation failed.",
  "data": null,
  "errors": {},
  "meta": {}
}
```

## API Responses

All API responses should use `App\Support\ApiResponse`.

Response shape:

```json
{
  "success": true,
  "message": "OK",
  "data": {},
  "errors": {},
  "meta": {}
}
```

HTTP status codes must use `App\Enums\HttpCodeEnum` instead of numeric literals.

## Implemented Modules

### User/Auth

Implemented endpoints:

- `POST /api/register`
- `POST /api/login`
- `POST /api/logout`
- `POST /api/password/email`
- `POST /api/password/reset`

Auth write flow:

```text
Request -> toCommand() -> Handler -> Pipeline -> DTO -> ApiResponse
```

### User/Profile

Implemented endpoints:

- `GET /api/user`
- `GET /api/profile`
- `PUT /api/profile`

Profile module structure:

- `Domain/ValueObjects`: `ProfileName`, `ProfileEmail`, `ProfilePhone`
- `Domain/Repositories`: `UserProfileRepositoryInterface`
- `Domain/Exceptions`: duplicate email/phone domain errors
- `Infrastructure/Repositories`: Eloquent repository implementation
- `Infrastructure/Pipelines`: update profile pipeline steps
- `Application/Queries`: current user/profile reads
- `Application/Commands`: profile update writes
- `Presentation/Http`: controller and request classes

Profile read flow:

```text
Controller -> Query -> QueryHandler -> Repository -> DTO -> ApiResponse
```

Profile write flow:

```text
UpdateProfileRequest -> UpdateProfileCommand -> UpdateProfileHandler -> Pipeline -> Repository -> DTO -> ApiResponse
```

### Product

Implemented endpoints:

- `GET /api/products`
- `POST /api/products`
- `GET /api/products/{product}`
- `PUT|PATCH /api/products/{product}`
- `DELETE /api/products/{product}`
- `GET /api/search`
- `POST /api/products/{product}/reviews`

Product module structure:

- `Domain/ValueObjects`: product specification filter/label definitions and normalization
- `Domain/Repositories`: `ProductRepositoryInterface`
- `Infrastructure/Repositories`: Eloquent implementation for products and reviews
- `Infrastructure/Pipelines`: create/update normalization and persistence pipeline
- `Application/Queries`: list/show/search product reads
- `Application/Commands`: create/update/delete/review writes
- `Presentation/Http`: controller and request classes

Product read flow:

```text
Controller -> Query -> QueryHandler -> Repository -> DTO -> ApiResponse
```

Product write flow:

```text
FormRequest -> toCommand() -> Handler -> Pipeline/Repository -> DTO -> ApiResponse
```

Product list filters and product detail characteristics are returned in `meta`, not as top-level response fields.

### Order

Implemented endpoints:

- `GET /api/orders`
- `GET /api/orders/{order}`
- `POST /api/orders`

Order module structure:

- `Domain/ValueObjects`: `OrderStatus`, `PaymentMethod`
- `Domain/Repositories`: `OrderRepositoryInterface`
- `Domain/Exceptions`: order access errors
- `Infrastructure/Repositories`: Eloquent order repository
- `Infrastructure/Pipelines`: create order pipeline for loading products, calculating totals, building payloads, and persisting
- `Application/Queries`: list/show order reads
- `Application/Commands`: create order writes
- `Presentation/Http`: controller and request classes

Order read flow:

```text
Controller -> Query -> QueryHandler -> Repository -> DTO -> ApiResponse
```

Order write flow:

```text
StoreOrderRequest -> CreateOrderCommand -> CreateOrderHandler -> Pipeline -> Repository -> DTO -> ApiResponse
```

Order pagination is returned in `meta`. Access to another user's order returns the shared API envelope with `403`.

## Running

Install backend dependencies:

```bash
cd api
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

Run tests:

```bash
cd api
php artisan test
```

Run only auth module tests:

```bash
cd api
php artisan test --filter=AuthModuleTest
```
