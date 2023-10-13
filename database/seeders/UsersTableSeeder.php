<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**
         * Create the admin user
         */
        $now = Carbon::now(); // Timestamp variable
        $admin = [
            'email' => 'test@gmail.com',
            'password' => bcrypt('123456789'),
            'created_at' => $now,
            'updated_at' => $now,
        ];

        DB::table('users')->insert($admin);

        /**
         * Create 10 fake users with UserFactory class
         */
        User::factory(10)->create();
    }
}
