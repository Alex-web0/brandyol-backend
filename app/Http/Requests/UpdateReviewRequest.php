<?php

namespace App\Http\Requests;

use App\OpenApi\Schemas\ReviewSchema;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UpdateReviewRequest extends FormRequest
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
            'rating' => ReviewSchema::$ratingRules,
            'content' => 'string|max:2048|required'
        ];
    }
}
