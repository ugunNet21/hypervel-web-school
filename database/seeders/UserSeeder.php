<?php

declare (strict_types = 1);

use App\Models\User;
use Hyperf\Database\Seeders\Seeder;
use Illuminate\Support\Str;


class UserSeeder extends Seeder
{
    private const USERS = [
        [
            'name'      => 'Super Admin',
            'username'  => 'superadmin',
            'email'     => 'superadmin@school.com',
            'password'  => 'password',
            'full_name' => 'Super Admin',
            'role'      => 'Super Admin',
        ],
        [
            'name'      => 'Kepala Sekolah',
            'username'  => 'kepsek',
            'email'     => 'kepsek@school.com',
            'password'  => 'password',
            'full_name' => 'Kepala Sekolah',
            'role'      => 'Kepala Sekolah',
        ],
        [
            'name'      => 'Guru',
            'username'  => 'guru',
            'email'     => 'guru@school.com',
            'password'  => 'password',
            'full_name' => 'Guru',
            'role'      => 'Guru',
        ],
        [
            'name'      => 'Siswa',
            'username'  => 'siswa',
            'email'     => 'siswa@school.com',
            'password'  => 'password',
            'full_name' => 'Siswa',
            'role'      => 'Siswa',
        ],
        [
            'name'      => 'Orang Tua',
            'username'  => 'ortu',
            'email'     => 'ortu@school.com',
            'password'  => 'password',
            'full_name' => 'Orang Tua',
            'role'      => 'Orang Tua',
        ],
        [
            'name'      => 'Staf TU',
            'username'  => 'tu',
            'email'     => 'tu@school.com',
            'password'  => 'password',
            'full_name' => 'Staf TU',
            'role'      => 'Staf TU',
        ],
        [
            'name'      => 'Konselor',
            'username'  => 'konselor',
            'email'     => 'konselor@school.com',
            'password'  => 'password',
            'full_name' => 'Konselor',
            'role'      => 'Konselor',
        ],
    ];

    /**
     * Seed the users table and assign roles.
     */
    public function run(): void
    {
        foreach (self::USERS as $userData) {
            $this->createUser($userData);
        }
    }

    /**
     * Create a user and assign their role if they don't already exist.
     */
    private function createUser(array $userData): void
    {
        // Check if user already exists by email or username
        $existingUser = User::where('email', $userData['email'])
            ->orWhere('username', $userData['username'])
            ->first();
    
        if ($existingUser) {
            // Update the existing user's role if needed
            $existingUser->syncRoles([$userData['role']]);
            return;
        }
    
        // Create the user
        $user = User::create([
            'name'              => $userData['name'],
            'username'          => $userData['username'],
            'email'             => $userData['email'],
            'full_name'         => $userData['full_name'],
            'email_verified_at' => now(),
            'password'          => Hash::make($userData['password']),
            'last_login_ip'     => null,
            'last_login_time'   => null,
            'key_status'        => null,
            'slug'              => Str::slug($userData['username']),
            'phone'             => null,
            'avatar_url'        => null,
            'is_active'         => true,
        ]);
    
        if (!empty($user->id)) {
            $user->assignRole($userData['role']);
        } else {
            throw new \Exception("User ID is not set when assigning role to: {$userData['email']}");
        }
    }
    
}