<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define resources
        $resources = [
            'users',
            'roles',
            'permissions',
            'elections',
            'candidates',
            'votes',
            'members',
            'categories',
            'accreditations',
        ];

        // Define actions
        $actions = ['view', 'create', 'edit', 'delete'];

        // Create permissions for each resource
        foreach ($resources as $resource) {
            foreach ($actions as $action) {
                Permission::firstOrCreate([
                    'name' => "{$action}_{$resource}",
                    'guard_name' => 'web',
                ]);
            }
        }

        // Create roles and assign permissions

        // Super Admin - All permissions
        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);
        $superAdmin->syncPermissions(Permission::all());

        // Admin - All except roles and permissions management
        $admin = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        $adminPermissions = Permission::where('name', 'not like', '%_roles')
            ->where('name', 'not like', '%_permissions')
            ->get();
        $admin->syncPermissions($adminPermissions);

        // Manager - Manage elections, candidates, votes, members
        $manager = Role::firstOrCreate(['name' => 'Manager', 'guard_name' => 'web']);
        $managerPermissions = Permission::where('name', 'like', '%_elections')
            ->orWhere('name', 'like', '%_candidates')
            ->orWhere('name', 'like', '%_votes')
            ->orWhere('name', 'like', '%_members')
            ->orWhere('name', 'like', '%_accreditations')
            ->get();
        $manager->syncPermissions($managerPermissions);

        // Viewer - Read-only access
        $viewer = Role::firstOrCreate(['name' => 'Viewer', 'guard_name' => 'web']);
        $viewerPermissions = Permission::where('name', 'like', 'view_%')->get();
        $viewer->syncPermissions($viewerPermissions);

        // Assign Super Admin role to first user if exists
        $firstUser = User::first();
        if ($firstUser && !$firstUser->hasAnyRole(['Super Admin', 'Admin', 'Manager', 'Viewer'])) {
            $firstUser->assignRole('Super Admin');
            $this->command->info("Assigned 'Super Admin' role to user: {$firstUser->email}");
        }

        $this->command->info('Roles and permissions seeded successfully!');
    }
}
