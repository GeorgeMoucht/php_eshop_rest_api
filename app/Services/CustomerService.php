<?php

namespace App\Services;

use App\Enums\ACL\Groups\GroupId;
use App\Models\Customer;

class CustomerService
{
    protected ResponseService $response;
    protected RoleService $role;

    public function __construct(ResponseService $response, RoleService $role)
    {
        $this->response = $response;
        $this->role = $role;
    }

    /**
     * Create a customer of current authenticated user.
     *
     * @param array $data
     * @return array|object|bool
     */
    public function create(array $data) : array|object|bool
    {
        if(me()->customer()->create($data))
        {
            return $this->role->update(GroupId::CUSTOMER->value);
        }
        return false;
    }

    /**
     * Create a specific customer base on user_id given
     * from URL.
     *
     * @param array $data
     * @param $user_id
     * @return array|object|bool
     */
    public function createSpecific(array $data, $user_id): array|object|bool
    {
        // TODO Check if the user_id actually exists in users table.

        $customer = new Customer();
        $customer->user_id = $user_id;
        $customer->fill($data);
        if($customer->save()){
            return $this->role->update(GroupId::CUSTOMER, $user_id);
        }
        return false;
    }
    /**
     * Retrieve the customer of current authenticated user.
     *
     */
    public function showAuthenticated()
    {
        return me()->customer;
    }

    /**
     * Retrieve the customer of a specific user
     *
     * @param $user_id
     */
    public function showSpecific($user_id)
    {
       return Customer::where('user_id', $user_id)->first();
    }

}
