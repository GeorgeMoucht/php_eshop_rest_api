<?php

declare(strict_types=1);


use Symfony\Component\VarDumper\VarDumper;


// Return the first rank that this user have in database.
if (!function_exists('my_role')) {
    /**
     * @return \Illuminate\Contracts\Auth\Authenticatable|null|string
     */
    function my_role()
    {
        $user_id = auth()->id();
        cache()->forget('my_role_' . $user_id);  //Delete the cache entry for the user

        return cache()->rememberForever('my_role_' . auth()->id(), function () {

            $role = auth()->user()->groups()->pluck('name')[0];

            if (!empty($role)) {
                return strtolower($role);
            }
            return '-';
        });
    }
}

// Returning a collection of the user
if (!function_exists('me')) {
    function me(): \App\Models\User
    {
        return auth()->user();
    }
}

// We dump without stop the process of the application
if (!function_exists('ndd')) {
    /**
     * @param mixed ...$vars
     */
    function ndd(...$vars)
    {
        foreach ($vars as $v) {
            VarDumper::dump($v);
        }
    }
}


// Check if the user has a particular permission
if (!function_exists('can')) {
    function can(string $permission): bool
    {
        $user = auth()->user();

        if($user) {
            return auth()->user()->hasPermission($permission);
        } else {
            return false;
        }
    }
}

// Check if the user don't have a particular permission
if (!function_exists('cannot')) {

    function cannot(string $permission): bool
    {
        $user = auth()->user();

        if($user) {
            return !$user->hasPermission($permission);
        } else
        {
            return false;
        }
    }
}

// If user can't execute the call then abort with status and message.
if (!function_exists('abort_if_cannot')) {

    function abort_if_cannot(string $permission_name)
    {
        return abort_if(cannot($permission_name), 403, "You dont have the required  \n\r[" . $permission_name . "]\n\r permissions to view this resource");
    }
}
