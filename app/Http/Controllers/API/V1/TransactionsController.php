<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Responses\ResponseSuccess;
use App\Http\Resources\PaginationResource;
use App\Http\Resources\TransactionsResource;
use App\Actions\Transactions\ListTransactionsAction;

class TransactionsController
{
    public function __invoke(): ResponseSuccess
    {
        $transactions = ListTransactionsAction::execute(request()->all());

        return new ResponseSuccess(
            message: 'Transactions retrieved',
            response: [
                'data' => TransactionsResource::collection($transactions),
                'meta' => $transactions->count() ? new PaginationResource($transactions) : []
            ]
        );
    }
}
