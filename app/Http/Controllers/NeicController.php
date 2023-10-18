<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;


final class NeicController extends ApiController
{
    /**
     * Return a list of items
     */
    public function index()
    {
        // Retrieve all permissions assigned to the auth user with his roles.
        ndd('my role', my_role());
        dd('getAllPermissionsFromUserAndRoles', me()->getAllPermissionsFromUserAndRoles());
//        ndd('getAllPermissionsFromRoles', me()->getAllPermissionsFromRoles());
//
//        ndd('getAllRoles', me()->getAllRoles());
//        ndd('getAllPermissions', me()->getAllPermissions());

        abort_if_cannot('post_order');
//
//        if(auth()->user()->hasPermission($permission)){
//            bla bla
//        }
//
//        can('post_order');

        $user = User::first();

//        dd($user->hasRoles(['administrator', 'user']));
//        dd($user->hasPermission(
//            permission: 'post_order',
//            permit: false
//        ));

        dd($user->hasPermission('post_order'));
//        $this->authorize('view', $order);
//
//        return new OrderResource($order);

        $user = User::query();

        if(request()->input('limit')){
            $user->limit(\request()->input('limit'));
        }

        if (request()->has('paginate')){
            $users = $user->paginate(2)->toArray();
        }else{
            $users = $user->get()->toArray();
        }

        return $this->apiResponse(
            payload: ['users' => $users],
            status: 1000,
            method: __METHOD__
        );

//        response.data.users.data <--  true|false
    }

    /**
     * Return a specific item
     */
    public function show(User $user)
    {

        return $this->apiResponse(
            payload: ['user' => $user->toArray()],
            status: 1000,
            method: __METHOD__
        );
    }


    /**
     * Store a new item
     */
    public function store(Request $request)
    {
        //
    }


    /**
     * Update an item
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Delete an item
     */
    public function destroy(string $id)
    {
        //
    }
}
