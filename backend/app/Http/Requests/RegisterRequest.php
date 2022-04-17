<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required|unique:App\Models\User,username|string|max:24|min:4',
            'display_name' => 'required|string|max:48',
            'email' => 'required|unique:App\Models\User,email|email:rfc',
            'password' => 'required|max:64|min:8',
            'gender' => 'required',
            'birthday' => 'required|date',
            'bio' => 'nullable|max:128',
            'avatar' => 'nullable|image|mimes:jpg,png,jpeg|max:10000',
        ];
    }
}
