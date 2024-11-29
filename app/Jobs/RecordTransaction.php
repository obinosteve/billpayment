<?php

namespace App\Jobs;

use App\Actions\Transactions\CreateTransactionAction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;

class RecordTransaction implements ShouldQueue
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
        DB::transaction(function () {
            CreateTransactionAction::execute($this->data);
        });
    }
}
