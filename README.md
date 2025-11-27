# Room Booking Admin Console

A focused Laravel 12 application that now ships with five core modules:

1. **System Logs** – review every change made to users, products, rooms, or room types.
2. **User Management** – create, edit, or deactivate platform users (regular, admin, super admin).
3. **Product Management** – manage bookable assets/products with unique IDs and status flags.
4. **Room Management** – track individual rooms with unique numbers, optional description, and status.
5. **Room Type Management** – define reusable room categories (e.g., Deluxe, Suite) with optional descriptions.

Everything else (templates, grades, assignments, user dashboards, etc.) has been removed from both the UI and database layer to keep the project lightweight.

## Features

### Role-based Access
- **Super Admin**
  - Full visibility of system logs.
  - Can create/update/delete users, products, rooms, and room types.
  - Only role that can delete records or assign the `super_admin` role to others.
- **Admin**
  - Can create and update users (but cannot delete them or grant super-admin privileges).
  - Can add and edit products, rooms, and room types.
  - Can review the system log history.
- **Regular User**
  - Can sign in, manage their profile, and use the product/room/room-type modules to add new entries or review/search existing records.
  - Cannot edit or delete other users’ entries once they are saved.

## Installation

### Prerequisites
- PHP >= 8.2
- Composer
- Node.js & NPM
- SQLite (or MySQL/PostgreSQL)

### Steps

1. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

2. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Database Setup**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

4. **Build Assets**
   ```bash
   npm run build
   ```

5. **Start Server**
   ```bash
   php artisan serve
   ```

## Default Users

After running `php artisan db:seed`, the following users are created:

- **Super Admin User**
  - Email: `admin@example.com`
  - Password: `password`
  - Role: Super Admin

- **Regular User**
  - Email: `user@example.com`
  - Password: `password`
  - Role: User

## Usage

### Super Admin Login
1. Navigate to `/login`
2. Login with `admin@example.com` / `password`
3. Use the left navigation (or the dashboard shortcuts) to open **System Logs**, **Manage Users**, **Manage Products**, **Manage Rooms**, or **Manage Room Types**.

### Admin Workflows
- **System Logs** – `Admin → System Logs` shows a paginated audit trail with summaries and contextual payload.
- **Manage Users** – CRUD interface for admins/regular users. Super Admins can delete users; Admins can create/update only.
- **Manage Products** – CRUD interface for products with generated `PRD-XXXX` IDs. Super Admins may delete products, Admins may add/edit, and Regular Users can add/review/search.
- **Manage Rooms** – CRUD interface for rooms with unique room numbers and optional descriptions. Permissions mirror the product module.
- **Manage Room Types** – CRUD interface for reusable room categories. Shares the same permission breakdown as rooms/products.

### Regular User Experience
Regular users can authenticate, manage their profile, and work exclusively inside the Product/Room modules (add new records and review/search the catalog).

## Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   └── Admin/
│   │       ├── LogController.php
│   │       ├── ProductController.php
│   │       ├── RoomController.php
│   │       ├── RoomTypeController.php
│   │       └── UserController.php
│   └── Middleware/
│       └── EnsureAdmin.php
└── Models/
    ├── Product.php
    ├── Room.php
    ├── RoomType.php
    ├── SystemLog.php
    └── User.php

database/
└── migrations/
    ├── 0001_01_01_000000_create_users_table.php
    ├── 0001_01_01_000001_create_cache_table.php
    ├── 0001_01_01_000002_create_jobs_table.php
    ├── 2025_10_31_050020_create_permission_tables.php
    ├── 2025_10_31_050031_add_role_to_users_table.php
    ├── 2025_10_31_174659_create_products_table.php
    ├── 2025_11_24_000000_create_system_logs_table.php
    ├── 2025_11_24_010000_create_rooms_table.php
    └── 2025_11_24_020000_create_room_types_table.php

resources/
└── views/
    ├── admin/
    │   ├── logs/
    │   │   └── index.blade.php
    │   ├── products/
    │   ├── rooms/
    │   ├── room-types/
    │   └── users/
    ├── layouts/
    │   └── sneat-admin.blade.php
    └── dashboard.blade.php
```

## Database Schema

### products
- `id`, `unique_id`, `title`, `is_active`, timestamps.

### rooms
- `id`, `room_no` (unique), `description` (nullable), `is_active`, timestamps.

### room_types
- `id`, `name` (unique), `description` (nullable), `is_active`, timestamps.

### system_logs
- `id`
- `action` (`user_created`, `product_deleted`, `room_type_updated`, etc.)
- `payload` (JSON summary/details)
- `performed_by` (nullable FK to `users`)
- timestamps

Other default tables (`users`, `roles`, `model_has_roles`, etc.) stay untouched from the Laravel + Spatie setup.

## Technologies Used

- **Laravel 12** - PHP Framework
- **Laravel Breeze** - Authentication scaffolding
- **Spatie Laravel Permission** - Role & Permission management
- **Tailwind CSS** - Styling (via Breeze)
- **SQLite** - Database (default)

## Routes

All feature routes are wrapped inside the `auth` middleware, and admin routes additionally use the custom `admin` middleware.

### Admin Routes
- `GET /admin/logs` – Paginated system log (Admins & Super Admins only).
- `GET|POST /admin/users/...` – Full resource controller for user CRUD (Admins & Super Admins).
- `GET|POST /admin/products/...` – Full resource controller for product CRUD (policies enforce who can add/edit/delete).
- `GET|POST /admin/rooms/...` – Full resource controller for room CRUD (same access pattern as products).
- `GET|POST /admin/room-types/...` – Full resource controller for room-type CRUD (same access pattern as rooms).

### Authenticated User Routes
- `GET /dashboard` – unified dashboard for every signed-in user.
- `GET /profile`, `PATCH /profile`, `DELETE /profile` – default Breeze profile management endpoints.

## License

This project is open-sourced software licensed under the MIT license.
