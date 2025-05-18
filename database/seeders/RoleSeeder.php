<?php

declare(strict_types=1);

use App\Models\Role;
use Hyperf\Database\Seeders\Seeder;

class RoleSeeder extends Seeder
{
    private const ROLES = [
        'Super Admin',
        'Kepala Sekolah',
        'Guru',
        'Siswa',
        'Orang Tua',
        'Staf TU',
        'Konselor',
    ];

    /**
     * Seed the roles table.
     */
    public function run(): void
    {
        foreach (self::ROLES as $role) {
            Role::firstOrCreate(
                ['name' => $role, 'guard_name' => 'web'], 
                ['guard_name' => 'web']
            );
        }
    }
}
