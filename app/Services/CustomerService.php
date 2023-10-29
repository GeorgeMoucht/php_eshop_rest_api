<?php

namespace App\Services;

use App\Enums\ACL\Groups\GroupId;
use App\Models\Customer;

class CustomerService
{
    protected ResponseService $response;
    protected RoleService $role;
    protected UserService $authUser;

    public function __construct(ResponseService $response, RoleService $role, UserService $authUser)
    {
        $this->response = $response;
        $this->role = $role;
        $this->authUser = $authUser;
    }

    /**
     * Create a customer of current authenticated user.
     *
     * @param array $data
     * @return array|object|bool
     */
    public function create(array $data) : array|object|bool
    {
        // Get the authenticated data and create then customer.
        if($this->authUser->getAuthenticatedUser()->customer()->create($data))
        {
            //Change the role of the user as customer.
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
        return $this->authUser->getAuthenticatedUser()->customer;
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

    public function index($limit, $page, $paginate): \Illuminate\Database\Eloquent\Collection|\Illuminate\Contracts\Pagination\LengthAwarePaginator|array
    {
        // Create query builder for "customers" model.
        $customers = Customer::query();

        // if limit provided, set to numbers to be returned.
        if ($limit) {
            $customers->limit($limit);
        }

        // Check if user wants paginated results.
        if($paginate) {
            return $customers->paginate($limit, ['*'], 'page', $page);
        }

        // Retrieve the data.
        return $customers->get();
    }

    public function updateAuthenticated(array $data): bool|int
    {
        if(!$this->authUser->getAuthenticatedUser()->customer()->first()) {
            return  false;
        }

        return $this->authUser->getAuthenticatedUser()->customer()->update($data);
    }

    public function updateSpecific(array $data, $user_id): bool|int
    {
        $customer = Customer::where('user_id', $user_id)->first();

        if(!$customer) {
            return false;
        }

        return $customer->update($data);
    }

    public function destroy($user_id)
    {
        // Make this customer user again
        $this->role->update(GroupId::USER->value);

        return Customer::where('user_id', $user_id)->first()->delete();
    }


    public function getAuthCustomerId() {
        if($this->authUser->getAuthenticatedUser()->customer->id)
        {
            return $this->authUser->getAuthenticatedUser()->customer->id;
        }
        return false;
    }
}
