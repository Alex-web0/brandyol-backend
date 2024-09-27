<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            // 'address' => 'required|string',
            // 'state_id' => 'required|numeric',
            // 'country_id' => 'required|numeric',
            'password' => 'required|string',
            'gender' => 'required|string|in:male,female,other',
            'phone_number' => 'required|unique:users',
            'role' => 'required|in:' . join(",", array_diff(config('roles'), ['customer']))
        ];
    }
}
