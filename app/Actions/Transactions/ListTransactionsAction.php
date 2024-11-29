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
            ->latest()
            ->paginate($per_page);


        return $transactions;
    }
}
