<?php

namespace App\Services;

use App\Enums\ACL\Groups\GroupId;

class RoleService
{
    public function updateUserToCustomer(): array
    {
        return me()->groups()->sync([GroupId::CUSTOMER->value]);
    }
}
