<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
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
        if ($this->input('username') && $this->input('email')) {

            if ($this->user()->username == $this->input('username')) {
                $username = '';
            } else {
                $username = 'unique:App\Models\User,username|string|max:24|min:4';
            }

            if ($this->user()->email == $this->input('email')) {
                $email = '';
            } else {
                $email = 'email|unique:App\Models\User,email';
            }


            return [
                'username'=> $username,
                'email'=> $email,
            ];
        }

        if ($this->input('display_name') && $this->input('bio')) {

            return [
                'display_name'=> 'string|max:48',
                'bio'=> 'max:128',
            ];

        }

        return [
            'avatar' => 'max:10000|image'
        ];
    }
}
