<?php

namespace App\Jobs;

use App\Models\WalletHistory;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class RecordWalletHistory implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(private array $data)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        WalletHistory::create([
            'wallet_id' => $this->data['wallet_id'],
            'user_id' => $this->data['user_id'],
            'transaction_id' => $this->data['transaction_id'],
            'wallet_balance' => $this->data['wallet_balance'],
            'transaction_date' => $this->data['transaction_date'],
        ]);
    }
}
