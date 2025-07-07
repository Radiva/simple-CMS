<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('settings')->insert([
            ['key' => 'site.name', 'value' => 'My Personal CMS'],
            ['key' => 'site.description', 'value' => 'CMS sederhana berbasis Laravel & Vue'],
            ['key' => 'contact.email', 'value' => 'hello@example.com'],
            ['key' => 'social.facebook', 'value' => 'https://instagram.com/example'],
            ['key' => 'social.instagram', 'value' => 'https://instagram.com/example'],
            ['key' => 'social.linkedin', 'value' => 'https://instagram.com/example'],
            ['key' => 'social.youtube', 'value' => 'https://instagram.com/example'],
        ]);
    }
}
