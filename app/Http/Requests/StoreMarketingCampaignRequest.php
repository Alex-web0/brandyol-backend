<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class StoreMarketingCampaignRequest extends FormRequest
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
            'from_date_joined' => 'date|nullable',
            'to_date_joined' => 'date|nullable',
            'from_total_orders' => 'numeric|nullable',
            'to_total_orders' => 'numeric|nullable',
            'image' => 'image|nullable',
            'title' => 'string|required',
            'body' => 'string|nullable',
            'type' => 'string|in:notification,whatsapp|required',
        ];
    }
}
