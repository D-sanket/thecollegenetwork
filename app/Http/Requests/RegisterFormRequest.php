<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterFormRequest extends FormRequest
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
            'email' => 'required|email|unique:users',
            'firstname' => 'required|min:3|max:30|regex:/[a-zA-Z]{3,30}/',
            'lastname' => 'required|min:3|max:30|regex:/[a-zA-Z]{3,30}/',
            'password' => 'required|min:6|max:15|regex:/^[a-zA-Z0-9]+$/',
            'confirm_password' => 'required|same:password',
            'course_year' => 'required|regex:/[1-4]{1,1}/'
        ];
    }
}
