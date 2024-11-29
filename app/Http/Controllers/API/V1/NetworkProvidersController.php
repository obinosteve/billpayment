<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Responses\ResponseSuccess;
use App\Models\NetworkProvider;
use Illuminate\Http\Response;

class NetworkProvidersController
{
    public function __invoke(): ResponseSuccess
    {
        return new ResponseSuccess(
            message: 'Network providers retrieved',
            status_code: Response::HTTP_OK,
            response: ['data' => NetworkProvider::get(['id', 'name'])->toArray()]
        );
    }
}
