<?php

namespace Database\Seeders;

use App\Enums\ACL\Groups\GroupId;
use App\Models\User;
use Illuminate\Database\Seeder;

class GroupUserTableSeeder extends Seeder
{
    public function run(): void
    {
        $this->generateUsersForGroups();
    }

    private function generateUsersForGroups(): void
    {
        $this->generateSuperAdmin();    // Create Super Admin
        $this->generateModerators();    // Create two mods
        $this->generateCustomersAndUsers(); // Randomly assign user/customers
    }

    private function generateSuperAdmin(): void
    {
        $groupsId = GroupId::getAdminIds();
        $payload = User::find(1);

        if ($payload) {
            $payload->groups()->sync($groupsId);
            echo "Super Admin assigned to groups: " . implode(',', $groupsId) . "\n";
        } else {
            echo "Super Admin user not found.\n";
        }
    }

    private function generateModerators(): void
    {
        $groupsId = GroupId::getModIds();
        $payloads = [
            User::find(2),
            User::find(3),
        ];

        foreach ($payloads as $payload) {
            if ($payload) {
                $payload->groups()->sync($groupsId);
                echo "Moderator {$payload->id} assigned to groups: " . implode(',', $groupsId) . "\n";
            } else {
                echo "Moderator user not found.\n";
            }
        }
    }

    private function generateCustomersAndUsers(): void
    {
        $otherUsers = User::whereNotIn('id', [1, 2, 3])->get();

        $otherUsers->each(function ($user) {
            $groupId = rand(0, 1) === 1 ? GroupId::getCustomerIds() : GroupId::getUserIds();
            $user->groups()->sync($groupId);
            echo "User {$user->id} assigned to group " . implode(',', $groupId) . "\n";
        });
    }
}
