<?php

namespace App\Http\Controllers;

use App\Enums\ACL\Permissions\PermissionName;
use App\Http\Requests\Customer\CustomerUpdateRequest;
use App\Models\Customer;
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
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        abort_if_cannot(PermissionName::INDEX_CUSTOMER->value, true);

        // Retrieve "limit" and "page" query params from the request, default 10 and 1 if not provided.
        $limit = $request->input('limit', 10);
        $page = $request->input('page', 1);

        // Get the "paginate" value from the request.
        $paginate = $request->input('paginate', false);

        $results = $this->customer->index($limit, $page, $paginate);

        return $this->apiResponse(
            payload: ["customer" => $results],
            status: 1000,
            method: __METHOD__,
        );
    }

    /**
     * Return the authenticated customer
     * @return JsonResponse
     */
    public function showAuthenticated(): JsonResponse
    {
        // dd(PermissionName::GET_CUSTOMER);
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
     * Return customer by user_id
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
     * Store a new customer based on authenticated user_id.
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
     * Store a new customer base on given user_id
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
     * Update authenticated customer
     * @param CustomerUpdateRequest $request
     * @return JsonResponse
     */
    public function updateAuthenticated(CustomerUpdateRequest $request): JsonResponse
    {
        // Update should be accessed as admin or mods only
        abort_if_cannot(PermissionName::PUT_CUSTOMER->value, true);

        // Check if entire request array is empty
        if($request->all() === []) {
            return $this->apiErrorResponse(
                payload: ['message' => "Data are empty. Please try again."],
                status: 404,
                method: __METHOD__,
                httpStatusCode: 404
            );
        }

        // Update the Customer data
        if($this->customer->updateAuthenticated($request->all())) {
            return $this->apiResponse(
                payload: ['message' => "Customer updated."],
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
     * Update a specific customer base on give user_id
     * @param CustomerUpdateRequest $request
     * @param $user_id
     * @return JsonResponse
     */
    public function updateSpecific(CustomerUpdateRequest $request, $user_id): JsonResponse
    {
        abort_if_cannot(PermissionName::PUT_SPECIFIC_CUSTOMER->value, true);

        // Check if entire request is empty
        if($request->all() === []) {
            return $this->apiErrorResponse(
                payload:['message' => "Data are empty. Please try again."],
                status: 404,
                method: __METHOD__,
                httpStatusCode: 404
            );
        }

        // Update the Customer data
        if($this->customer->updateSpecific($request->all(), $user_id)) {
            return $this->apiResponse(
                payload: ['message' => "Customer updated."],
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
     * Delete a specific user
     * @param string $user_id
     * @return JsonResponse
     */
    public function destroy(string $user_id): JsonResponse
    {
        abort_if_cannot(PermissionName::DESTROY_CUSTOMER->value, true);

        if($this->customer->destroy($user_id)) {
            return $this->apiResponse(
                payload: ['message' => "Customer deleted."],
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
}
