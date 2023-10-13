<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupHasPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $now = Carbon::now();
        $groupHasPerm = [
            [ // Admin group permission
              'group_id' => 1,
              'permission_id' => 1,
            ],
            [ // Moderator group permission
                'group_id' => 2,
                'permission_id' => 2,
            ],
            [ // Customer group permission
                'group_id' => 3,
                'permission_id' => 3,
            ],
            [ // User group permission
                'group_id' => 4,
                'permission_id' => 4,
            ],
        ];

        DB::table('group_has_permission')->insert($groupHasPerm);

    }
}
