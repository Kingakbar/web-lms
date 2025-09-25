<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ==== Permissions ====
        $permissions = [
            // Course
            'create course', 'edit course', 'delete course', 'publish course',
            // Lesson
            'create lesson', 'edit lesson', 'delete lesson',
            // User Management
            'manage users', 'assign roles',
            // Enrollment & Payment
            'manage enrollments', 'manage payments', 'apply promo',
            // Review & Certificate
            'leave review', 'manage reviews', 'issue certificate',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // ==== Roles ====
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $instructor = Role::firstOrCreate(['name' => 'instructor']);
        $student = Role::firstOrCreate(['name' => 'student']);

        // Assign permissions
        $admin->givePermissionTo(Permission::all());

        $instructor->givePermissionTo([
            'create course', 'edit course', 'delete course', 'publish course',
            'create lesson', 'edit lesson', 'delete lesson',
        ]);

        $student->givePermissionTo([
            'leave review', 'apply promo',
        ]);
    }
}
