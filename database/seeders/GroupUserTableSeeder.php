<?php

namespace Database\Seeders;

use App\Enums\ACL\Groups\GroupId;
use App\Models\User;
use Illuminate\Database\Seeder;

class GroupUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    private array $groupsId;

    public function __construct() {
        $this->groupsId = [
            GroupId::ADMINISTRATOR,
            GroupId::MODERATOR,
            GroupId::CUSTOMER,
            GroupId::USER,
        ];
    }
    public function run(): void
    {
        /**
         * GROUPS
         *  1 --> administrators
         *  2 --> moderators
         *  3 --> customers
         *  4 --> users
         */
        $this->generateUsersForGroups();
    }

    /**
     * Generate All dummy data we need for our users and groups.
     * @return void
     */
    private function generateUsersForGroups(): void {
        $this->generateSuperAdmin();    // Create Super Admin
        $this->generateModerators();    // Create two mods
        $this->generateCustomersAndUsers(); // random assign user/customers

    }

    /**
     * Make the first user as Super Admin.
     * @return void
     */
    private function generateSuperAdmin(): void
    {
        $groupsId = GroupId::getAdminIds();
        // Group table data
        $payload = User::find(1);
        $payload->groups()->sync($groupsId);
    }

    /**
     * Create user's with id 1 and 2 as Moderators.
     * @return void
     */
    private function generateModerators(): void
    {
        $groupsId = GroupId::getModIds();
        $payloads = [
            User::find(2),
            User::find(3),
        ];

        foreach($payloads as $payload) {
            $payload->groups()->sync($groupsId);
        }
    }

    /**
     * Assign all users except [1,2,3]
     * (which are the super admin and mods)
     * as random user/customer.
     * @return void
     */
    private function generateCustomersAndUsers(): void
    {
        $otherUsers = User::whereNotIn('id', [1,2,3])->get();
        $otherUsers->each(function ($user) {
            if(rand(0,1) === 1) {
                $groupId = GroupId::getCustomerIds();
            }
            else {
                $groupId = GroupId::getUserIds();
            }
            $user->groups()->sync($groupId);
        });
    }

}

