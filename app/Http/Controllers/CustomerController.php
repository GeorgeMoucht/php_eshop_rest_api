<?php

namespace App\Http\Controllers;

use App\Enums\ACL\Permissions\PermissionName;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\CustomerService;
use App\Http\Requests\Customer\CustomerCreateRequest;

class CustomerController extends ApiController
{
    protected CustomerService $customer;

    public function __construct(CustomerService $customer)
    {
        $this->middleware('auth');
        $this->customer = $customer;
    }

    /**
     * Return list of customers
     * @return void
     */
    public function index()
    {

    }

    /**
     * Return the authenticated customer
     * @return JsonResponse
     */
    public function showAuthenticated(): JsonResponse
    {
//        dd(PermissionName::GET_CUSTOMER);
        // Check if the user have the permission or not.
        abort_if_cannot(PermissionName::GET_CUSTOMER->value, true);

        $customer = $this->customer->showAuthenticated();

        if($customer)
        {
            return $this->apiResponse(
                payload: ["customer" => $customer],
                status: 1000,
                method: __METHOD__,
            );
        }
        return $this->apiErrorResponse(
            payload: ["message" => 'Customer not found.'],
            status: 404,
            method:__METHOD__,
            httpStatusCode: 404,
        );
    }

    /**
     * Return customer by user_id.
     *
     * @param $user_id
     * @return JsonResponse
     */
    public function showSpecific($user_id): JsonResponse
    {
        abort_if_cannot(PermissionName::GET_SPECIFIC_CUSTOMER->value,true);

        $customer = $this->customer->showSpecific($user_id);

        if($customer) {
            return $this->apiResponse(
                payload: ["customer" => $customer],
                status: 1000,
                method: __METHOD__,
            );
        }

        return $this->apiErrorResponse(
            payload: ["message" => 'Customer not found.'],
            status: 404,
            method:__METHOD__,
            httpStatusCode: 404,
            );
    }

    /**
     * Store a new customer based on
     * authenticated user_id.
     *
     * @param CustomerCreateRequest $request
     * @return JsonResponse
     */
    public function store(CustomerCreateRequest $request): JsonResponse
    {
        // Check if user don't have the permission
        abort_if_cannot(PermissionName::POST_CUSTOMER->value, true);

        // Create the customer
        if($this->customer->create($request->all()))
        {
            return $this->apiResponse(
                payload: ['message' => "Customer has been created."],
                status: 1000,
                method: __METHOD__,
            );
        }
        return $this->apiErrorResponse(
            payload: ['message' => "Can't create customer. Something went wrong."],
            status: 404,
            method: __METHOD__,
            httpStatusCode: 404
        );

        // Change user group to customer.


    }

    /**
     * Store a new customer base
     * on given user_id
     * @param CustomerCreateRequest $request
     * @param $user_id
     * @return JsonResponse
     */
    public function storeSpecific(CustomerCreateRequest $request, $user_id): JsonResponse
    {
        abort_if_cannot(PermissionName::POST_SPECIFIC_CUSTOMER->value, true);

        // Create the customer
        if($this->customer->createSpecific($request->all(), $user_id))
        {
            return $this->apiResponse(
                payload: ['message' => "Customer has been created."],
                status: 1000,
                method: __METHOD__,
            );
        }

        return $this->apiErrorResponse(
            payload: ['message' => "Something went wrong."],
            status: 404,
            method: __METHOD__,
            httpStatusCode: 404
        );
    }

    /**
     * Update an item
     */
    public function update(Request $request, string $id)
    {

    }

    /** Delete an Item
     */
    public function destroy(string $id)
    {

    }
}
