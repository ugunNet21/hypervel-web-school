<?php

declare(strict_types=1);

use Hyperf\Database\Seeders\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Manually run each seeder
        (new RoleSeeder())->run();
        (new PermissionSeeder())->run();
        (new UserSeeder())->run();
        (new DirectPermissionSeeder())->run();
    }
}
