<?php

declare (strict_types = 1);

use App\Models\Permission;
use App\Models\Role;
use Hyperf\Database\Seeders\Seeder;

class PermissionSeeder extends Seeder
{
    private const PERMISSIONS = [
        'view_dashboard',
        'manage_users',
        'manage_e_learning',
        'manage_e_raport',
        'manage_online_exam',
        'manage_digital_library',
        'manage_ppdb',
        'manage_analytics',
        'manage_career_development',
        'manage_parent_portal',
        'manage_school_management',
        'manage_monetization',
        'manage_ai_assistant',
        'manage_roles',
        'view_reports',
        'generate_reports',
    ];

    private const ROLE_PERMISSIONS = [
        'Super Admin'    => [
            'view_dashboard',
            'manage_users',
            'manage_e_learning',
            'manage_e_raport',
            'manage_online_exam',
            'manage_digital_library',
            'manage_ppdb',
            'manage_analytics',
            'manage_career_development',
            'manage_parent_portal',
            'manage_school_management',
            'manage_monetization',
            'manage_ai_assistant',
            'manage_roles',
            'view_reports',
            'generate_reports',
        ],
        'Kepala Sekolah' => [
            'view_dashboard',
            'manage_users',
            'manage_e_learning',
            'manage_e_raport',
            'manage_online_exam',
            'manage_digital_library',
            'manage_ppdb',
            'manage_analytics',
            'manage_school_management',
            'view_reports',
            'generate_reports',
        ],
        'Guru'           => [
            'view_dashboard',
            'manage_e_learning',
            'manage_e_raport',
            'manage_online_exam',
            'view_reports',
        ],
        'Siswa'          => [
            'view_dashboard',
            'manage_e_learning',
            'manage_online_exam',
            'manage_digital_library',
        ],
        'Orang Tua'      => [
            'view_dashboard',
            'manage_parent_portal',
            'view_reports',
        ],
        'Staf TU'        => [
            'view_dashboard',
            'manage_ppdb',
            'manage_school_management',
            'view_reports',
            'generate_reports',
        ],
        'Konselor'       => [
            'view_dashboard',
            'manage_career_development',
            'view_reports',
        ],
    ];

    /**
     * Seed the permissions table and assign permissions to roles.
     */
    public function run(): void
    {
        $this->createPermissions();
        $this->assignPermissionsToRoles();
    }

    /**
     * Create permissions if they don't exist.
     */
    private function createPermissions(): void
    {
        foreach (self::PERMISSIONS as $permission) {
            Permission::firstOrCreate([
                'name'       => $permission,
                'guard_name' => 'web', // ✅ 
            ]);
        }
    }

    /**
     * Assign permissions to each role based on predefined rules.
     */
    private function assignPermissionsToRoles(): void
    {
        foreach (self::ROLE_PERMISSIONS as $roleName => $permissions) {
            $role = Role::where('name', $roleName)->first();

            if (! $role) {
                continue; // skip if role not found
            }

            foreach ($permissions as $permissionName) {
                $permission = Permission::where('name', $permissionName)->first();

                if ($permission) {
                    // Pastikan untuk menambahkan ke pivot table role_has_permissions
                    \App\Models\RoleHasPermission::firstOrCreate([
                        'role_id'       => $role->id,
                        'permission_id' => $permission->id,
                    ]);
                }
            }
        }
    }

}
