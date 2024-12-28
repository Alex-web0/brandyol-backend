<?php

namespace App\Http\Requests;

use App\Models\Review;
use App\OpenApi\Schemas\RatingSchema;
use App\OpenApi\Schemas\ReviewSchema;
use Illuminate\Foundation\Http\FormRequest;

class GetReviewsRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'rating' => 'nullable|numeric',
            'did_buy' => 'nullable|boolean',
            'product_id' => 'nullable|numeric',
            'user_id' => 'nullable|numeric',
            'most_likes' => 'nullable|boolean',
        ];
    }
}
