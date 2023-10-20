<?php

namespace App\Services;

use App\Models\Group;
use App\Models\User;

class RoleService
{
    /**
     * Update user group.
     *
     * @param $newRole
     * @param $user_id
     * @return array
     */
    public function update($newRole, $user_id=null): array
    {
        // If user_id exists, it means we want to update a specific user to customer
        if($user_id) {
            $user = User::find($user_id);
            $group = Group::find($newRole);

            return $user->groups()->sync([$group->id]);
        }
        return me()->groups()->sync($newRole);
    }
}
