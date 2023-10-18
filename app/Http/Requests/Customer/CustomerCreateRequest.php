<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CustomerCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'contact_lastname'  => 'required|string|max:45',
            'contact_firstname' => 'required|string|max:45',
            'phone'             => 'required|string|max:45',
            'address_line_1'    => 'required|string|max:100',
            'address_line_2'    => 'nullable|string|max:100',
            'city'              => 'required|string|max:45',
            'state'             => 'required|string|max:45',
            'postal_code'       => 'required|string|max:10',
            'country'           => 'required|string|max:45',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'The :attribute field is required.',
            'string'   => 'The :attribute must be string.',
            'max'      => 'The :attribute may not be greater than :max characters',
        ];
    }


}
