# User Management System - Laravel + Bootstrap 5

A comprehensive user management system built with **Laravel 13**, **Blade templating**, **Bootstrap 5**, and **Spatie Laravel Permission** for role-based access control (RBAC).

## Features

✅ **Role-Based Access Control (RBAC)**

- 3 default roles: Admin, Manager, User
- 14 permissions across 4 categories
- Dynamic role assignment

✅ **Authentication & Authorization**

- User login/registration with email verification
- Role-based dashboard routing
- Middleware protection for routes

✅ **User Management**

- Full CRUD operations (Create, Read, Update, Delete)
- User listing with search and filtering
- Role assignment and management
- Active/Inactive status management

✅ **Admin Dashboard**

- System statistics and user metrics
- Recent user activity
- Role distribution overview
- Quick action buttons

✅ **Manager Dashboard**

- User management interface
- Team statistics
- User verification status

✅ **User Dashboard**

- Personal profile overview
- Account information
- Verification status

✅ **Responsive UI**

- Built with Bootstrap 5
- Sneat Admin Template integration
- Mobile-friendly design
- Modern card-based layouts

## Tech Stack

- **Framework**: Laravel 13
- **Database**: MySQL
- **Templating**: Blade (Laravel)
- **Frontend**: Bootstrap 5 + Sneat Admin Template
- **Authentication**: Laravel built-in
- **Permissions**: Spatie Laravel Permission (v7.3+)
- **UI Components**: Bootstrap icons, modals, tables, forms

## Installation & Setup

### Prerequisites

- PHP 8.3 or higher
- MySQL 5.7 or higher
- Composer
- Node.js & npm (optional, for asset compilation)

### Step 1: Clone & Install Dependencies

```bash
# Install PHP dependencies
composer install

# Create environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Install Node dependencies (optional)
npm install
```

### Step 2: Configure Database

Edit `.env` file:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=manajemen_user_laravel
DB_USERNAME=root
DB_PASSWORD=
```

Create database:

```bash
mysql -u root -p -e "CREATE DATABASE manajemen_user_laravel;"
```

### Step 3: Run Migrations & Seeders

```bash
# Run all migrations
php artisan migrate

# Seed database with roles, permissions, and default users
php artisan db:seed --class=DatabaseSeeder
```

### Step 4: Start Development Server

```bash
php artisan serve
```

The application will be available at `http://localhost:8000`

## Default Login Credentials

After running migrations & seeders, use these credentials to login:

| Role    | Email               | Password    |
| ------- | ------------------- | ----------- |
| Admin   | admin@example.com   | password123 |
| Manager | manager@example.com | password123 |
| User    | user@example.com    | password123 |

## Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   └── UserController.php          # User CRUD operations
│   └── Middleware/
│       ├── RoleMiddleware.php          # Role-based access control
│       └── RedirectIfAuthenticated.php # Guest middleware
│
database/
├── migrations/                          # Database schema
└── seeders/
    └── DatabaseSeeder.php              # Roles, permissions, default users
│
resources/
├── views/
│   ├── layouts/
│   │   ├── app.blade.php              # Master layout
│   │   └── partials/
│   │       ├── sidebar.blade.php      # Navigation sidebar
│   │       ├── navbar.blade.php       # Top navigation
│   │       └── footer.blade.php       # Footer
│   ├── auth/
│   │   ├── login.blade.php            # Login page
│   │   └── register.blade.php         # Registration page
│   ├── dashboards/
│   │   ├── admin.blade.php            # Admin dashboard
│   │   ├── manager.blade.php          # Manager dashboard
│   │   └── user.blade.php             # User dashboard
│   ├── users/
│   │   ├── index.blade.php            # User listing
│   │   ├── create.blade.php           # Create user form
│   │   ├── edit.blade.php             # Edit user form
│   │   └── show.blade.php             # User details view
│   └── profile/
│       └── edit.blade.php             # User profile edit
│
routes/
└── web.php                             # Web routes with middleware
│
public/
└── assets/                             # Sneat template assets
```

## Routes Overview

### Public Routes

- `GET /` - Home page (redirects to dashboard if authenticated)
- `GET /login` - Login page
- `POST /login` - Login action
- `GET /register` - Registration page
- `POST /register` - Registration action
- `POST /logout` - Logout action

### Protected Routes (Authenticated Users)

- `GET /dashboard` - Dashboard (role-based redirect)
- `GET /dashboards/admin` - Admin dashboard
- `GET /dashboards/manager` - Manager dashboard
- `GET /dashboards/user` - User dashboard
- `GET /profile` - Profile edit page

### Admin/Manager Routes (RBAC: admin,manager)

- `GET /users` - User listing
- `GET /users/create` - Create user form
- `POST /users` - Store new user
- `GET /users/{user}` - Show user details
- `GET /users/{user}/edit` - Edit user form
- `PUT /users/{user}` - Update user
- `DELETE /users/{user}` - Delete user

## User Roles & Permissions

### Admin Role

All 14 permissions:

- `view_users`, `create_user`, `edit_user`, `delete_user`
- `manage_roles`, `manage_permissions`
- `view_statistics`, `export_data`
- `verify_user`, `block_user`
- `edit_own_profile`, `view_own_profile`
- `manage_system`, `access_admin_panel`

### Manager Role

8 permissions:

- `view_users`, `create_user`, `edit_user`, `view_statistics`
- `verify_user`, `edit_own_profile`, `view_own_profile`, `export_data`

### User Role

2 permissions:

- `edit_own_profile`, `view_own_profile`

## Migration & Seeding Details

### Database Tables

- `users` - User accounts with personal information
- `roles` - Role definitions (admin, manager, user)
- `permissions` - Permission list (14 permissions)
- `model_has_roles` - User-to-role assignments
- `role_has_permissions` - Role-to-permission assignments

### Default Seeder Creates

1. **3 Roles**:
    - Admin: Full system access
    - Manager: User management capabilities
    - User: Basic user with limited permissions

2. **14 Permissions**:
    - User Management: view, create, edit, delete
    - Role/Permission: manage, access
    - Statistics: view, export
    - Verification: verify, block
    - Profile: edit own, view own
    - System: manage, access panel

3. **3 Default Users**:
    - admin@example.com (Role: Admin)
    - manager@example.com (Role: Manager)
    - user@example.com (Role: User)

## Key Features Explained

### 1. Role-Based Access Control via Middleware

Routes are protected using the `role` middleware:

```php
Route::middleware('role:admin,manager')->group(function () {
    Route::resource('users', UserController::class);
});
```

### 2. Eager Loading for Performance

UserController uses `with('roles')` to prevent N+1 queries:

```php
$users = User::with('roles')->paginate(15);
```

### 3. Dynamic Role-Based Navigation

Sidebar conditionally shows menu items based on user roles:

```blade
@if(auth()->user()->hasRole(['admin', 'manager']))
  <!-- User Management Menu -->
@endif
```

### 4. Delete Protection

System prevents users from deleting their own account:

```php
if (auth()->id() === $user->id) {
    return back()->with('error', 'You cannot delete your own account!');
}
```

### 5. Role-Based Dashboard Routing

Dashboard automatically redirects users to appropriate dashboard:

```php
Route::get('/dashboard', function () {
    if (auth()->user()->hasRole('admin')) {
        return redirect()->route('dashboards.admin');
    }
    // ...
})->name('dashboard');
```

## Common Tasks

### Add a New User via Admin Panel

1. Login as admin
2. Click "Manage Users" → "Add New User"
3. Fill in user details and select roles
4. Click "Create User"

### Assign Role to Existing User

1. Go to Users list
2. Click "Edit" on the user
3. Check/uncheck role checkboxes
4. Click "Update User"

### Create New Role (Requires Code Modification)

Edit `database/seeders/DatabaseSeeder.php`:

```php
$newRole = Role::firstOrCreate(['name' => 'new_role']);
$newRole->syncPermissions(['permission1', 'permission2']);
```

Then run:

```bash
php artisan migrate:refresh --seed
```

### Add New Permission (Requires Code Modification)

Edit `database/seeders/DatabaseSeeder.php`:

```php
Permission::firstOrCreate(['name' => 'new_permission']);
```

## Customization

### Change Asset Path

The system uses `asset()` helper for asset paths. All assets are in `public/assets/`

### Modify Sidebar Navigation

Edit `resources/views/layouts/partials/sidebar.blade.php`

### Add New Dashboard Statistics

Edit `resources/views/dashboards/{role}.blade.php`

### Customize User Fields

Modify `app/Http/Controllers/UserController.php` validation rules and `$user->create()` calls

## Troubleshooting

### "Class not found" errors

```bash
# Clear application cache
php artisan cache:clear

# Regenerate application cache
php artisan cache:config

# Regenerate autoloader
composer dump-autoload
```

### Migration errors

```bash
# Rollback all migrations
php artisan migrate:reset

# Run fresh migrations
php artisan migrate
```

### Permission denied errors

```bash
# Fix storage permissions (Linux/Mac)
chmod -R 775 bootstrap/cache storage
```

### "Middleware not registered" error

Verify middleware alias is in `bootstrap/app.php`:

```php
$middleware->alias([
    'role' => \App\Http\Middleware\RoleMiddleware::class,
]);
```

## Security Considerations

1. **Password Security**: All passwords are hashed with bcrypt
2. **CSRF Protection**: All forms include CSRF tokens
3. **Authorization**: Routes protected with role middleware
4. **Input Validation**: All user inputs are validated server-side
5. **SQL Injection**: Using Eloquent ORM prevents SQL injection
6. **Email Verification**: All seeded users have verified emails

## Performance Optimization

1. **Eager Loading**: Controllers use `->with('roles')` to prevent N+1 queries
2. **Pagination**: User lists paginated to prevent large data transfers
3. **Caching**: Dashboard statistics use database queries (can be cached)
4. **Asset Optimization**: Sneat template uses minified CSS/JS

## Support & Contributing

For issues, suggestions, or contributions, please open an issue or pull request.

## License

This project is open-source and available under the MIT License.

---

**Built with ❤️ using Laravel 13, Bootstrap 5, and Spatie Laravel Permission**
