<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $now = Carbon::now();
        $groups = [
            [
                'name' => 'administrators',
            ],
            [
                'name' => 'moderators',
            ],
            [
                'name' => 'customers',
            ],
            [
                'name' => 'users',
            ],
        ];

        DB::table('groups')->insert($groups);
    }
}
