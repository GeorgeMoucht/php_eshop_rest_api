<?php

namespace App\Enums\ACL\Permissions;

enum PermissionId: int
{
    case GET_USER = 1;
    case GET_ROLE = 2;
    case GET_CUSTOMER = 3;
    case GET_ORDER = 4;
    case GET_PRODUCT = 5;
    case POST_USER = 6;
    case POST_ROLE = 7;
    case POST_CUSTOMER = 8;
    case POST_ORDER = 9;
    case POST_PRODUCT = 10;
    case PUT_USER = 11;
    case PUT_ROLE = 12;
    case PUT_CUSTOMER = 13;
    case PUT_ORDER = 14;
    case PUT_PRODUCT = 15;
    case DESTROY_USER = 16;
    case DESTROY_ROLE = 17;
    case DESTROY_CUSTOMER = 18;
    case DESTROY_ORDER = 19;
    case DESTROY_PRODUCT = 20;

    /**
     * Return Admin values that are all case.
     *
     * @return array
     */
    public static function getAdminPermissions(): array
    {
        $allValues = [];
        $reflectionClass = new \ReflectionClass(self::class);

        foreach  ($reflectionClass->getConstants() as $name=>$value) {
            $allValues[] = $value;
        }

        return  $allValues;
    }

    /**
     * Return Moderator values
     */
    public static function getModPermissions(): array
    {
        return [
            self::GET_USER,
            self::GET_ROLE,
            self::GET_CUSTOMER,
            self::GET_ORDER,
            self::GET_PRODUCT,

            self::POST_ORDER,
            self::POST_PRODUCT,
            self::POST_USER,
            self::POST_CUSTOMER,

            self::PUT_USER,
            self::PUT_CUSTOMER,
            self::PUT_ORDER,
            self::PUT_PRODUCT,

            self::DESTROY_USER,
            self::DESTROY_CUSTOMER,
            self::DESTROY_ORDER,
            self::DESTROY_PRODUCT,
        ];
    }

    public static function getCustomerPermissions(): array
    {
        return [
            self::GET_USER,
            self::GET_CUSTOMER,
            self::GET_ORDER,
            self::GET_PRODUCT,

            self::POST_ORDER,

            self::PUT_USER,
            self::PUT_CUSTOMER,
        ];
    }

    public static function getUserPermissions(): array
    {
        return [
            self::GET_USER,
            self::GET_PRODUCT,

            self::POST_CUSTOMER,

            self::PUT_USER,
        ];
    }
}
