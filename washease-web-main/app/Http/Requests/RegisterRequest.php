<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'address' => 'required|string',
            'phone_number' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string',
            'laundry_shop_name' => 'required_if:role,LaundryShop',
            'laundry_shop_latitude' => 'required_if:role,LaundryShop',
            'laundry_shop_longitude' => 'required_if:role,LaundryShop',
            'laundry_shop_address' => 'required_if:role,LaundryShop',
            'laundry_shop_permit' => 'required_if:role,LaundryShop',
            'laundry_shop_open_hours' => 'required_if:role,LaundryShop',
            'is_shop_closed' => 'required_if:role,LaundryShop',
            'user_lat' => 'required_if:role,Customer',
            'user_long' => 'required_if:role,Customer',
            'role' => 'required|string'
        ];
    }
}
