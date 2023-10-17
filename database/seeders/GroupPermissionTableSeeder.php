<?php

namespace Database\Seeders;

use App\Enums\ACL\Permissions\PermissionId;
use App\Enums\ACL\Groups\GroupId;
use App\Models\Group;
use Illuminate\Database\Seeder;

class GroupPermissionTableSeeder extends Seeder
{
    /**
     * Groups Table
     *  ____________________
     *  | id | name          |
     *  | 1  | administratos |
     *  | 2  | moderators    |
     *  | 3  | customers     |
     *  | 4  | users         |
     *  ____________________
     *
     *  Permissions Table
     *
     *  1,view_user
     *  2,edit_user
     *  3,delete_user
     *  4,create_user
     *  5,create_customer
     *  6,view_customer
     *  7,edit_customer
     *  8,delete_customer
     *  9,create_order
     *  10,view_order
     *  11,edit_order
     *  12,delete_order
     *  13,create_product
     *  14,edit_product
     *  15,delete_product
     *  16,view_product
     *
     */

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->generateGroupPermissions();
    }

    private function generateGroupPermissions(): void
    {
        $this->generateAdminPermissions();
        $this->generateModeratorPermissions();
        $this->generateCustomerPermissions();
        $this->generateUserPermissions();
    }

    private function generateAdminPermissions(): void
    {
        // Retrieve Administrator permissions
        $adminPermissions = PermissionId::getAdminPermissions();

        // Convert enum values to integers
        $adminPermissionIds = array_map(function ($permission) {
            return $permission->value;
        },$adminPermissions);

        // Find the Administrator group by ID
        $adminGroup = Group::find(GroupId::ADMINISTRATOR);

        if($adminGroup) {
            // Associate the Group with Permission
            $adminGroup->permissions()->sync($adminPermissionIds);

            $this->command->info('ADmin group permissions have been set');
        } else {
            $this->command->error("administrator group not found.");
        }
    }

    private function generateModeratorPermissions(): void
    {
        $permissions = PermissionId::getModPermissions();

        $permissionIds = array_map(function ($permission){
            return $permission->value;
        }, $permissions);

        $groupId = Group::find(GroupId::MODERATOR);

        if($groupId) {
            $groupId->permissions()->sync($permissionIds);
        } else {
            $this->command->error("moderator group not found");
        }
    }

    private function generateCustomerPermissions(): void
    {
        $permissions = PermissionId::getCustomerPermissions();

        $permissionIds = array_map(function ($permission) {
            return $permission->value;
        }, $permissions);

        $groupId = Group::find(GroupId::CUSTOMER);

        if($groupId) {
            $groupId->permissions()->sync($permissionIds);
        } else {
            $this->command->error('Customer Group not found');
        }
    }

    private function generateUserPermissions(): void
    {
        $permissions = PermissionId::getUserPermissions();

        $permissionIds = array_map(function ($permission) {
            return $permission->value;
        }, $permissions);

        $groupId = Group::find(GroupId::USER);

        if($groupId) {
            $groupId->permissions()->sync($permissionIds);
        } else {
            $this->command->error('User group not found');
        }
    }


}
