<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;

class CustomerService
{

    public function create(array $data) : array|object
    {
        return me()->customer()->create($data);
    }
}
