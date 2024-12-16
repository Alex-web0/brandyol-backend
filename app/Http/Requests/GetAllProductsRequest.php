<?php

namespace App\Http\Requests;

use App\Helpers\Helper;
use Illuminate\Foundation\Http\FormRequest;

class GetAllProductsRequest extends FormRequest
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
            'stock' => 'nullable|integer',
            'price' => 'nullable|numeric',
            'cost' => 'nullable|numeric',
            'name' => 'nullable|string',
            'name_kr' => 'nullable|string',
            'discount' => Helper::$getDiscountValidator,
            'brand_id' => 'nullable|integer',
            'user_id' => 'nullable|integer',
            'color_scheme_id' => 'nullable|integer',
            'shuffle' => 'nullable|boolean',
            // 'stock' => 'nullable|integer',
            // 'stock' => 'nullable|integer',
        ];
    }
}
