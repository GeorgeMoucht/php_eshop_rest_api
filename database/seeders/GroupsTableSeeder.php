<?php

namespace Database\Seeders;

use App\Enums\ACL\Groups\GroupName;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupsTableSeeder extends Seeder
{
    protected array $groups;

    public function __construct()
    {
        $this->groups = [
            GroupName::ADMINISTRATOR,
            GroupName::MODERATOR,
            GroupName::CUSTOMER,
            GroupName::USER,
        ];
    }


    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('groups')->insert($this->generateGroupsArray());
    }

    /**
     * @return array
     */
    public function generateGroupsArray(): array
    {
        $payload = [];
        foreach ($this->groups as $group) {
            $payload[] = ['name' => $group];
        }
        return $payload;
    }
}
