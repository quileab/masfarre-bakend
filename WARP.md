# WARP.md

This file provides guidance to WARP (warp.dev) when working with code in this repository.

## Project Overview

This is a Laravel 12 application called "Masfarre Backend" - a budget/quote management system for catering events. The project uses modern Laravel stack with Livewire/Volt for interactive components and Mary UI for the frontend components. It manages products, budgets, users, and event types for catering businesses.

## Key Technologies

- **Backend**: Laravel 12 with PHP 8.2+
- **Frontend**: Livewire 3.6+ with Volt (single-file components)
- **UI Framework**: Mary UI 2.2+ (TailwindCSS-based components)
- **CSS Framework**: TailwindCSS 4.1+ with DaisyUI 5.0+
- **Build Tool**: Vite 6.2+
- **Authentication**: Laravel Sanctum for API tokens
- **Database**: SQLite (default) with Eloquent ORM

## Development Commands

### Quick Start Development
```bash
composer run dev  # Starts server, queue worker, and Vite in parallel
```
This is the main development command that runs concurrently:
- `php artisan serve` (development server)
- `php artisan queue:listen --tries=1` (queue worker)
- `npm run dev` (Vite asset compilation)

### Individual Commands
```bash
# Backend development
php artisan serve                    # Start development server
php artisan tinker                   # Interactive REPL
php artisan migrate                  # Run database migrations
php artisan migrate:fresh --seed    # Fresh migration with seeders
php artisan queue:work               # Process queue jobs

# Frontend development  
npm run dev                          # Start Vite development server
npm run build                        # Build production assets

# Testing
composer run test                    # Run all PHPUnit tests
php artisan test                     # Alternative test command
php artisan test --filter=TestName  # Run specific test

# Code quality
./vendor/bin/pint                    # Laravel Pint (code formatting)
```

### Maintenance Commands
```bash
# Cache management (visit /clear in browser or use artisan)
php artisan optimize:clear           # Clear all caches
php artisan config:clear            # Clear config cache
php artisan route:clear             # Clear route cache
php artisan view:clear              # Clear view cache

# Optimization for production
php artisan optimize                # Cache configs, routes, views
php artisan config:cache           # Cache configuration
php artisan route:cache            # Cache routes
```

## Application Architecture

### Core Domain Models

The application revolves around a **budget management system** with these key entities:

- **Budget**: Central entity representing event quotes/budgets
- **Product**: Catalog items that can be included in budgets  
- **User**: Both admin users (who create budgets) and client users (who receive them)
- **Category**: Product categorization
- **EventType**: Types of catering events (weddings, parties, etc.)

### Key Relationships

```
Budget belongs to:
  - Admin (User with admin role) 
  - Client (User)  
  - EventType
  - Category

Budget has many:
  - Products (pivot table: budget_product with quantity, price, notes)

Product belongs to:
  - Category

Product has many:
  - Budgets (through pivot table)
```

### Authentication & Authorization

- **Admin users**: Can create/edit budgets, manage products, access dashboard
- **Client users**: Can view their assigned budgets only
- **API Authentication**: Sanctum tokens for API endpoints
- **Web Authentication**: Traditional session-based auth

### Frontend Architecture (Livewire/Volt)

The app uses **Volt** (single-file Livewire components) located in `resources/views/livewire/`:

**Key Components:**
- `dashboard.blade.php`: Calendar view showing budgets by date
- `budget/crud.blade.php`: Budget creation/editing form
- `budget/detail.blade.php`: Detailed budget view with products
- `budget/index.blade.php`: Budget listing
- `products/crud.blade.php`: Product management
- `users/crud.blade.php`: User management

**Component Structure**: Each Volt component contains:
1. PHP class definition with Livewire logic
2. Blade template with Mary UI components

### API Endpoints

Located in `routes/api.php`:
- Authentication: `POST /api/login`, `POST /api/logout`
- Public endpoints: `GET /api/posts`, `GET /api/categories`, `GET /api/products`
- User data: `GET /api/user` (authenticated), `GET /api/user/{id}` (public example)

### Route Structure

**Web Routes** (`routes/web.php`):
- Public: `/` (landing page), `/login`
- Admin-only: `/dashboard`, `/users`, `/products`, `/categories`, `/budgets` (full CRUD)
- Client access: `/budgets` (view only), `/budgets/{id}/view`
- Maintenance: `/clear` (cache clearing utility)

## Database Schema

### Key Migrations
- `create_users_table.php`: Base user authentication
- `create_budgets_table.php`: Main budget entity
- `create_products_table.php`: Product catalog  
- `create_categories_table.php`: Product categorization
- `create_event_types_table.php`: Event type definitions
- `create_budget_product_table.php`: Many-to-many pivot with pricing

### Important Fields
**Budgets**: `name`, `date`, `total`, `status` (draft/sent/approved/rejected), `admin_id`, `client_id`
**Products**: `name`, `category_id`, standard Laravel timestamps
**Pivot table**: `quantity`, `price`, `notes` for budget-product relationships

## Development Patterns

### Model Conventions
- All models use `protected $guarded = []` (mass assignment protection disabled)
- Relationships follow Laravel conventions
- Budget model has dual user relationships (admin/client)

### Volt Component Patterns
- Business logic in anonymous PHP class extending `Component`
- Use `#[Computed]` attributes for derived properties
- Form handling with `updateOrCreate` pattern
- Mary UI components for consistent styling
- Toast notifications via `Mary\Traits\Toast`

### UI/UX Patterns
- Calendar-based dashboard for budget visualization
- CRUD operations use consistent Mary UI card layouts
- Responsive grid layouts with TailwindCSS
- Status-based styling and workflow management

## Testing

- PHPUnit configured for Feature and Unit tests
- Uses SQLite in-memory database for testing
- Test environment configuration in `phpunit.xml`
- Run tests with `composer run test` or `php artisan test`

## Deployment Notes

- Uses SQLite by default (suitable for small to medium applications)
- Vite handles asset compilation and versioning
- Maintenance route `/clear` for production cache management
- Laravel Pint for consistent code styling

## File Structure Focus

```
app/Models/           # Eloquent models with relationships
resources/views/livewire/  # Volt components (main UI logic)
routes/web.php        # Protected and public web routes  
routes/api.php        # API endpoints for external consumption
database/migrations/  # Database schema definitions
public/              # Web root with index.php
config/              # Laravel configuration files
```