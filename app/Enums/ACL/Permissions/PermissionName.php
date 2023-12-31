<?php

namespace App\Enums\ACL\Permissions;

enum PermissionName: string
{
    case GET_USER = 'get_user';
    case GET_ROLE = 'get_role';
    case GET_CUSTOMER = 'get_customer';
    case GET_ORDER = 'get_order';
    case GET_PRODUCT = 'get_product';
    case POST_USER = 'post_user';
    case POST_ROLE = 'post_role';
    case POST_CUSTOMER = 'post_customer'; // Auth create his own customer
    case POST_ORDER = 'post_order';
    case POST_PRODUCT = 'post_product';
    case PUT_USER = 'put_user';
    case PUT_ROLE = 'put_role';
    case PUT_CUSTOMER = 'put_customer';
    case PUT_ORDER = 'put_order';
    case PUT_PRODUCT = 'put_product';
    case DESTROY_USER = 'destroy_user';
    case DESTROY_ROLES = 'destroy_roles';
    case DESTROY_CUSTOMER = 'destroy_customer';
    case DESTROY_ORDER = 'destroy_order';
    case DESTROY_PRODUCT = 'destroy_product';
    case INDEX_CUSTOMER = 'index_customer';
    case PUT_SPECIFIC_CUSTOMER = 'put_specific_customer';
    case GET_SPECIFIC_CUSTOMER = 'get_specific_customer';
    case POST_SPECIFIC_CUSTOMER = 'post_specific_customer'; // Admin or mod create a customer base on user_id
    case GET_SPECIFIC_ORDER = 'get_specific_order';
    case PUT_SPECIFIC_ORDER = 'put_specific_order';
}
