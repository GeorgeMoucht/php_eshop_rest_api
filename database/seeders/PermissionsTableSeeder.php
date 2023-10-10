<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $now = Carbon::now();
        $permissions = [
            [
                'permission_name' => 'admin',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'permission_name' => 'moderator',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'permission_name' => 'customer',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'permission_name' => 'user',
                'created_at' => $now,
                'updated_at' => $now,
            ]
        ];

        DB::table('permissions')->insert($permissions);

    }
}
