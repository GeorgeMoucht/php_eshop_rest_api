<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsersTableSeeder::class,
            GroupsTableSeeder::class,
            PermissionsTableSeeder::class,
            GroupUserTableSeeder::class,
            GroupPermissionTableSeeder::class,
            PermissionUserTableSeeder::class,
            CustomerTableSeeder::class,
        ]);

        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('config:clear');
    }
}
