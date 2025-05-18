<?php

declare(strict_types=1);

use App\Models\ModelHasPermission;
use App\Models\Permission;
use App\Models\User;
use Hyperf\Database\Seeders\Seeder;

class DirectPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $superAdmin = User::where('email', 'superadmin@school.com')->first();
        if ($superAdmin) {
            $permission = Permission::where('name', 'manage_ai_assistant')->first();
            if ($permission) {
                ModelHasPermission::firstOrCreate([
                    'permission_id' => $permission->id,
                    'model_type' => User::class,
                    'model_id' => $superAdmin->id,
                ]);
            }
        }
    }
}

