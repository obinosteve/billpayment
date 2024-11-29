<?php

namespace App\Http\Requests;

use Illuminate\Http\Response;
use App\Enums\ResponseMessage;
use App\Http\Responses\ResponseError;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class BaseRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator, $this->buildJsonResponse($validator));
    }

    protected function buildJsonResponse(Validator $validator): ResponseError
    {
        return new ResponseError(
            message: ResponseMessage::getLabel(ResponseMessage::FAILED_VALIDATION),
            data: $validator->errors()->all(),
            status_code: Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
