<?php

use App\Enums\ResponseMessage;
use Illuminate\Http\Response;
use App\Exceptions\IncompleteRequestException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

function getExceptionCode(Exception $e)
{
    if ($e instanceof ModelNotFoundException) {
        return Response::HTTP_NOT_FOUND;
    }

    if ($e instanceof IncompleteRequestException) {
        return Response::HTTP_BAD_REQUEST;
    }

    return Response::HTTP_INTERNAL_SERVER_ERROR;
}

function getExceptionMessage(Exception $e)
{
    if ($e instanceof ModelNotFoundException) {
        return $e->getMessage();
    }

    if ($e instanceof IncompleteRequestException) {
        return $e->getMessage();
    }

    logException($e);

    return ResponseMessage::getLabel(ResponseMessage::INCOMPLETE_REQUEST);
}

function logException(Exception $e)
{
    Log::error('Server Error', [
        'class' => get_class($e),
        'line' => $e->getLine(),
        'message' => $e->getMessage()
    ]);
}

function getTransactionData(array $data): array
{
    return [
        'user_id' => $data['user_id'],
        'wallet_id' => $data['wallet_id'],
        'wallet_balance' => $data['wallet_balance'],
        'amount' => (float) $data['amount'],
        'request_type' => $data['request_type'],
        'transaction_type' => $data['transaction_type'],
        'transaction_date' => now(),
        'notes' => $data['notes'],
        'status' => $data['status'],
        'recipient' => !empty($data['recipient']) ? $data['recipient'] : null,
        'network_provider_id' => !empty($data['network_provider_id']) ? $data['network_provider_id'] : null,
        'transaction_reference' => !empty($data['transaction_reference']) ? $data['transaction_reference'] : null,
    ];
}
