<?php

namespace App\Http\Requests;

use App\Http\Requests\Traits\UserRegistrationErrorMessage;
use Illuminate\Foundation\Http\FormRequest;

class UserRegistrationRequest extends FormRequest
{

    use UserRegistrationErrorMessage;

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
            'name' => 'required|min:3|max:20',
            'email' => 'required|min:3|max:50|unique:users',
            'type' => 'required|min:3|max:20',
            'bio' => 'required|min:10',
            'photo' => 'mimes:jpg,jpeg,bmp,png',
            'password' => 'required|min:6|max:25',
        ];
    }


}
