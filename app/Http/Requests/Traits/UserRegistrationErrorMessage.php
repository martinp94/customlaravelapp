<?php

namespace App\Http\Requests\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Validation\ValidationException;

trait UserRegistrationErrorMessage 
{

	protected function failedValidation( Validator $validator ) 
    {
    	/*$errorMessage = 'error message je bijo';

        throw new HttpResponseException(response()->json(['error' => $errorMessage], 422));*/
        throw (new ValidationException($validator))
                    ->errorBag($this->errorBag)
                    ->redirectTo($this->getRedirectUrl());
    }
}