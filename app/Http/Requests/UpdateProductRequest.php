<?php

namespace App\Http\Requests;

use App\Helpers\Helper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(Request $request): bool
    {
        return $request->user()->is_admin_account();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'name_kr' => 'string',
            'description' => 'required|string',
            'usage' => 'string',
            'stock' => 'integer|required',
            'price' => 'numeric|required',
            'cost' => 'numeric|required',
            'discount' => Helper::$getDiscountValidator,
            'color_scheme_id' => 'integer|required|exists:color_schemes,id',
            'brand_id' => 'integer|required|exists:brands,id',
            'is_available' => 'boolean|nullable',
        ];
    }
}
