<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest as baseFormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class FormRequest extends baseFormRequest
{
    protected function failedValidation(Validator $validator)
    {
        $response = new JsonResponse([
                                         'success' => false,
                                         'data'    => null,
                                         'message' => 'The given data is invalid',
                                         'errors'  => $validator->errors(),

                                     ]
            ,                        422);


        throw new ValidationException($validator, $response);
    }
}
