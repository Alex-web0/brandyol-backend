<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    // /**
    //  * Determine if the user is authorized to make this request.
    //  */
    // public function authorize(): bool
    // {
    //     return false;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'full_name' => 'required|string',
            'gender' => 'required|int:male,female,other',
            // 'address' => 'required|string',
            // 'state_id' => 'required|numeric',
            // 'country_id' => 'required|numeric',
            'role' => 'required|in:' . join(",", array_diff(config('roles'), []))
        ];
    }
}
