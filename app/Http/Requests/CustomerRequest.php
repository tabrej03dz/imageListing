<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
            'email' => 'required|email',
            'phone' => 'required',
            'start_date' => 'date',
            'expiry_date' => 'date',
            'status' => 'required',
            'business_name' => 'required',
            'country' => '',
            'state' => '',
            'city' => '',
            'pin' => '',
            'address' => '',
            'gst_number' => '',
            'password' => 'string|min:8|nullable',
            'confirm_password' => 'same:password|nullable',

        ];
    }
}
