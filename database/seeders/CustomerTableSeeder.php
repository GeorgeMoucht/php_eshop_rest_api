<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\GroupUser;
use Database\Factories\CustomerFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Retrieve the user_id from group_permission table with group_id equal to 3 ( 3 is the customer)
        $userIds = GroupUser::where('group_id', 3)->pluck('user_id')->toArray();

        foreach($userIds as $userId) {
            Customer::factory()->create([
                'user_id' => $userId,
            ]);
        }
    }
}
