<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Cek jika role 'admin' sudah ada, jika belum, buat
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Buat user baru
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'), // Ubah password ini sesuai kebutuhan
        ]);

        // Assign role 'admin' ke user
        $user->assignRole($adminRole);

        echo "Admin user created successfully!";
    }
}
