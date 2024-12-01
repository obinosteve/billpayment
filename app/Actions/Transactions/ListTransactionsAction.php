<?php

namespace App\Actions\Transactions;

use App\Models\Transaction;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListTransactionsAction
{
    public static function execute(array $data): LengthAwarePaginator
    {
        $per_page = !empty($data['perPage']) ? $data['perPage'] : 25;

        $transactions = Transaction::query()
            ->with('provider')
            ->when(!empty($data['providerId']), fn($builder) => $builder->where('network_provider_id', $data['providerId']))
            ->when(!empty($data['transactionType']), fn($builder) => $builder->where('transaction_type', $data['transactionType']))
            ->when(!empty($data['requestType']), fn($builder) => $builder->where('request_type', $data['requestType']))
            ->when(!empty($data['transactionStatus']), fn($builder) => $builder->where('status', $data['transactionStatus']))
            ->latest()
            ->paginate($per_page);


        return $transactions;
    }
}
