<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class CustomerUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'contact_lastname'  => 'sometimes|string|max:45',
            'contact_firstname' => 'sometimes|string|max:45',
            'phone'             => 'sometimes|string|max:45',
            'address_line_1'    => 'sometimes|string|max:100',
            'address_line_2'    => 'sometimes|string|max:100',
            'city'              => 'sometimes|string|max:45',
            'state'             => 'sometimes|string|max:45',
            'postal_code'       => 'sometimes|string|max:10',
            'country'           => 'sometimes|string|max:45',
        ];
    }

    public function messages(): array
    {
        return [
            'sometimes' => 'The :attribute may be included if provided.',
            'string'    => 'The :attribute must be a string.',
            'max'       => 'The :attribute may not be greater than :max characters',
        ];
    }
}
