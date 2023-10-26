<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderCreateRequest extends FormRequest
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
            'comments'                  => 'sometimes|string|max:255',
            'order'                     => 'required|array',
            'order.*.product_id'        => 'required|integer',
            'order.*.quantity_ordered'  => 'required|integer',
        ];
    }

    public function messages(): array
    {
        return [
            'comments.string'                       => 'Comments must be type of string.',
            'order.required'                        => 'Thew order field is required.',
            'order.array'                           => 'The order must be type of array.',
            'order.*.product_id.required'           => 'Each order product item must have a product_id.',
            'order.*.product_id.integer'            => 'The product_id must be type of integer.',
            'order.*.quantity_ordered.required '    => 'Each product should have quantity_ordered attribute.',
            'order.*.quantity_ordered.integer'      => 'The quantity_ordered must be type of integer.'
        ];
    }
}
