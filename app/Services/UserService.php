<?php

namespace App\Services;

class UserService
{

    /**
     * Return authenticated user data.
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function getAuthenticatedUser(): ?\Illuminate\Contracts\Auth\Authenticatable
    {
        return auth()->user();
    }
    /**
     * Return the id of authenticated user.
     * @return mixed
     */
    public function getUserId()
    {
        return auth()->user()->id;
    }
}
