<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Database\Factories\UserFactory;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    public function getJWTIdentifier(): mixed
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }

    /**
     * Establish one-to-many relationship with groups
     */
    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class);
    }

    /**
     * Establish one-to-many relationship with permissions
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class,);
    }

    /**
     * Establish one-to-one relationship with customers
     */
    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class);
    }

    /**
     *  Return the first role that his user has.
     * @return bool
     */
    public function hasRoles(array $roles): bool
    {

        if ($this->groups->whereIn('name', $roles)->first()) {
            return true;
        }

        return false;
    }

    /**
     * Get all permissions of this user form permission-user
     * pivot table
     * @return array
     */
    public function getAllPermissions(): array
    {
        return $this->permissions()->pluck('name')->toArray();
    }

    public function getAllRoles(): array
    {
        return $this->groups()->pluck('name')->toArray();
    }

    /**
     *  Get all permssions from the assign role of the user.
     * @return array
     */
    public function getAllPermissionsFromRoles(): array
    {
        return $this->groups->flatMap(function ($role) {
            return $role->permissions->pluck('name');
        })->unique()->toArray();
    }

    /**
     * Get all permissions from group_permission and permissions_user
     * tables.
     * @return array
     */
    public function getAllPermissionsFromUserAndRoles(): array
    {
        return array_unique(array_merge($this->getAllPermissions(), $this->getAllPermissionsFromRoles()));
    }

    /**
     * Check if a user has permission to make
     * a specific call in the api.
     *
     * @param string $permission
     * @return bool
     */
    public function hasPermission(string $permission, $permit = true): bool
    {

        $cacheName = 'user_id' . auth()->id() . '_has_permissions_' . $permission;

        return cache()->rememberForever($cacheName, function () use ($permission) {
            // check for individual permission assigned.
            if ($this->permissions->where('name', $permission)->first()) {
                return true;
            }
            // If any of the user roles that the user's roles has the permission
            $rolePermissions = [];

            //get all the roles / groups
            foreach ($this->groups as $role) {
                //get all the permissions for this role
                foreach ($role->permissions as $perm) {
                    //flush out all permissions
                    $rolePermissions[] = $perm->name;
                }
            }


            return in_array($permission, array_unique($rolePermissions));
        });
    }

}
