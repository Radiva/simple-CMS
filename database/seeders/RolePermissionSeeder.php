<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat role dasar
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'editor']);
        Role::firstOrCreate(['name' => 'pengikut']);

        // Buat user admin awal
        $admin = User::firstOrCreate([
            'email' => 'admin@cms.test',
        ], [
            'name' => 'Super Admin',
            'password' => bcrypt('password'), // ganti untuk produksi
        ]);

        $admin->assignRole('admin');

        // Optional: buat 1 editor dan pengikut juga
        User::firstOrCreate([
            'email' => 'editor@cms.test',
        ], [
            'name' => 'Editor Awal',
            'password' => bcrypt('password'),
        ])->assignRole('editor');

        User::firstOrCreate([
            'email' => 'user@cms.test',
        ], [
            'name' => 'Pengikut Pertama',
            'password' => bcrypt('password'),
        ])->assignRole('pengikut');
    }
}
