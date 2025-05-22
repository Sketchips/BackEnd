<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Membuat user admin
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Membuat user biasa
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password123'),
            'role' => 'user',
        ]);

        // Membuat token untuk user biasa
        $token = $user->createToken('Flexy')->plainTextToken;

        // Tampilkan token (opsional)
        echo "Token untuk {$user->email}: {$token}\n";
        echo "Admin dibuat dengan email: {$admin->email} dan password: password\n";
    }
}
