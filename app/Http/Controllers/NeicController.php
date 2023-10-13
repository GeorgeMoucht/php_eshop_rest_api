<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;


final class NeicController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
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
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
