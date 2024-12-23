<?php

namespace App\Http\Controllers\API\V1;

use Exception;
use Illuminate\Http\Response;
use App\Http\Responses\ResponseError;
use App\Http\Responses\ResponseSuccess;
use App\Actions\Wallet\FundWalletAction;
use App\Http\Requests\FundWalletRequest;

class WalletController
{
    public function checkBalance(): ResponseSuccess
    {

        return new ResponseSuccess(
            message: 'Balance retrieved',
            response: [
                'data' =>  [
                    'totalAmount' => (float) request()->user()->wallet->balance,
                ]
            ]
        );
    }

    public function fundWallet(FundWalletRequest $request): ResponseSuccess|ResponseError
    {
        // We assumed the following had been done:

        // Setup payment processor
        // Redirect user to the payment gateway to make payment
        // Or listen for payment webhook
        // verified user's payment
        // Logged the payment transaction, if successful, then proceed

        try {
            (new FundWalletAction)->execute($request->all());
        } catch (Exception $e) {
            return new ResponseError(getExceptionMessage($e), getExceptionCode($e));
        }

        return new ResponseSuccess(
            message: 'Wallet funded successfully',
            status_code: Response::HTTP_OK,
        );
    }
}
