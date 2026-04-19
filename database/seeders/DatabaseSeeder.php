<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        // Create all permissions
        $permissions = [
            // User Management Permissions
            'view users',
            'create users',
            'edit users',
            'delete users',
            'export users',

            // System Management Permissions
            'view system logs',
            'manage system settings',
            'view system statistics',

            // Profile Permissions
            'edit own profile',
            'view own profile',

            // Verification Permissions
            'verify users',
            'approve users',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create Roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $managerRole = Role::firstOrCreate(['name' => 'manager']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Assign permissions to Admin role (has all permissions)
        $adminRole->syncPermissions(Permission::all());

        // Assign permissions to Manager role
        $managerRole->syncPermissions([
            'view users',
            'create users',
            'edit users',
            'view system statistics',
            'verify users',
            'edit own profile',
            'view own profile',
        ]);

        // Assign permissions to User role (limited permissions)
        $userRole->syncPermissions([
            'edit own profile',
            'view own profile',
        ]);

        // Create Admin User
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrator',
                'password' => bcrypt('password123'),
                'phone' => '+1234567890',
                'address' => '123 Admin Street',
                'city' => 'Admin City',
                'country' => 'Admin Country',
                'postal_code' => '12345',
                'profile_completion_percentage' => 100,
                'is_active' => true,
                'email_verified_at' => now(),
                'verified_at' => now(),
                'last_login_at' => now()->subHours(2),
            ]
        );
        $adminUser->assignRole('admin');

        // Create Manager User
        $managerUser = User::firstOrCreate(
            ['email' => 'manager@example.com'],
            [
                'name' => 'Sarah Manager',
                'password' => bcrypt('password123'),
                'phone' => '+0987654321',
                'address' => '456 Manager Avenue',
                'city' => 'Manager City',
                'country' => 'Manager Country',
                'postal_code' => '54321',
                'profile_completion_percentage' => 85,
                'is_active' => true,
                'email_verified_at' => now(),
                'verified_at' => now(),
                'last_login_at' => now()->subHours(4),
            ]
        );
        $managerUser->assignRole('manager');

        // Create Regular User
        $regularUser = User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'John Doe',
                'password' => bcrypt('password123'),
                'phone' => '+1122334455',
                'address' => '789 User Lane',
                'city' => 'User City',
                'country' => 'User Country',
                'postal_code' => '99999',
                'profile_completion_percentage' => 60,
                'is_active' => true,
                'email_verified_at' => now(),
                'verified_at' => now()->subDays(5),
                'last_login_at' => now()->subHours(12),
            ]
        );
        $regularUser->assignRole('user');

        $this->command->info('✓ Roles and permissions created successfully');
        $this->command->info('✓ 3 default users created: admin@example.com, manager@example.com, user@example.com');
        $this->command->info('✓ All users set with password: password123');
    }
}