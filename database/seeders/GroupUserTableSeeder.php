<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class GroupUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['user_id' => 1, 'group_id' => [1,2,3,4]],
            ['user_id' => 2, 'group_id' => [2]],
        ];

        foreach($users as $user) {
            $u = User::find($user['user_id']);
            $u->groups()->sync($user['group_id']);
            $u->save();
        }
    }
}
