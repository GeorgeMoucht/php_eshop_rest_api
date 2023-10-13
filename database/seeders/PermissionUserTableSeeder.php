<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Enums\ACL\Permissions\PermissionId;
use App\Models\User;

class PermissionUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->giveRolePermToUser();
    }

    private function giveRolePermToUser(): void
    {
        $user = User::find(2);
        $payloads = [
            PermissionId::POST_ROLE,
            PermissionId::PUT_ROLE,
            PermissionId::GET_ROLE,
            PermissionId::DESTROY_ROLE,
        ];
            // Extract the IDs from the enum instances
        $permissionIds = array_map(fn ($enum) => $enum->value, $payloads);

            $user->permissions()->sync($permissionIds);

    }
}
