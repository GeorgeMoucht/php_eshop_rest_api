<?php

namespace App\Enums\ACL\Groups;

enum GroupId: int
{
    case ADMINISTRATOR = 1;
    case MODERATOR = 2;
    case CUSTOMER = 3;
    case USER = 4;


    public static function getAdminIds(): array
    {
        return [
            self::ADMINISTRATOR->value,
        ];
    }

    public static function getModIds(): array
    {
        return [
            self::MODERATOR->value,
        ];
    }

    public static function getCustomerIds(): array
    {
        return [
            self::CUSTOMER->value,
        ];
    }

    public static function getUserIds(): array
    {
        return [
            self::USER->value,
        ];
    }
}
