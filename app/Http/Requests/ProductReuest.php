<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductReuest extends FormRequest
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
            'name' => 'required',
            'store_id' => 'required',
            'image' => 'required',
            'description' => 'required',
            'status' => 'required',
            'category_id' => 'required',
            'price' => 'required|numeric',
            'compare_price' => 'required',
        ];
    }
}
