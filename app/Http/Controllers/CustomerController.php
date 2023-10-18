<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\RoleService;
use App\Services\CustomerService;
use App\Http\Requests\Customer\CustomerCreateRequest;

class CustomerController extends ApiController
{
    protected CustomerService $customer;
    protected RoleService $role;

    public function __construct(CustomerService $customer, RoleService $role)
    {
        $this->middleware('auth');
        $this->customer = $customer;
        $this->role = $role;
    }
    /**
     * Return list of customers
     * @return void
     */
    public function index()
    {

    }

    /**
     *Return a specific customer
     */
    public function show(Customer $customer)
    {

    }

    /**
     * Store a new customer
     */
    public function store(CustomerCreateRequest $request): \Illuminate\Http\JsonResponse
    {
        // Check if user don't have the permission
        abort_if_cannot('post_customer', true);

        // Create the customer
        $this->customer->create($request->all());

        // Change user group to customer
        $this->role->updateUserToCustomer();

        return response()->json([
            'message' => 'Customer has been created',
        ]);
    }

    /**
     * Update an item
     */
    public function update(Request $request, String $id)
    {

    }

    /** Delete an Item
     */
    public function destroy(string $id)
    {

    }
}
