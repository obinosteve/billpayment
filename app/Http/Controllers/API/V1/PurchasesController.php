<?php

namespace App\Http\Controllers\API\V1;

use Exception;
use Illuminate\Http\Response;
use App\Http\Responses\ResponseError;
use App\Http\Responses\ResponseSuccess;
use App\Actions\Purchases\PurchaseAirtimeAction;
use App\Http\Requests\PurchaseAirtimeRequest;
use App\Http\Resources\PurchaseAirtimeResource;

class PurchasesController
{
    public function airtime(PurchaseAirtimeRequest $request): ResponseSuccess|ResponseError
    {
        try {
            (new PurchaseAirtimeAction)->execute($request->all());
        } catch (Exception $e) {
            return new ResponseError(getExceptionMessage($e), getExceptionCode($e));
        }

        return new ResponseSuccess(
            message: 'Airtime purchased successfully',
            status_code: Response::HTTP_OK,
            response: [
                'data' => new PurchaseAirtimeResource($request)
            ]
        );
    }
}
