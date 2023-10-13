<?php

namespace App\Enums\ACL\Groups;

enum GroupName: string
{
    case ADMINISTRATOR = 'administrator';
    case MODERATOR = 'moderator';
    case CUSTOMER = 'customer';
    case USER = 'user';
}
