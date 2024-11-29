<?php

namespace App\Actions\Transactions;

use App\Jobs\RecordWalletHistory;
use App\Models\Transaction;

class CreateTransactionAction
{
    public static function execute(array $data)
    {
        $transaction = Transaction::create([
            'user_id' => $data['user_id'],
            'wallet_id' => $data['wallet_id'],
            'network_provider_id' => $data['network_provider_id'],
            'transaction_reference' => $data['transaction_reference'],
            'amount' => (float) $data['amount'],
            'request_type' => $data['request_type'],
            'transaction_type' => $data['transaction_type'],
            'transaction_date' => $data['transaction_date'],
            'status' => $data['status'],
            'notes' => $data['notes'],
            'recipient' => $data['recipient'],
        ]);

        $data['transaction_id'] = $transaction->id;

        // Record the transaction history after successful creation
        dispatch(new RecordWalletHistory($data))->afterCommit();
    }
}
