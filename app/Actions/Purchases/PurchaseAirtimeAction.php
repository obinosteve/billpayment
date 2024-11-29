<?php

namespace App\Actions\Purchases;

use Exception;
use App\Models\User;
use App\Enums\Status;
use App\Models\Wallet;
use App\Enums\RequestType;
use App\Enums\TransactionType;
use App\Jobs\RecordTransaction;
use Illuminate\Support\Facades\DB;
use App\Actions\Wallet\UpdateWalletAction;
use App\Exceptions\IncompleteRequestException;
use App\Actions\Transactions\CreateTransactionAction;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PurchaseAirtimeAction
{
    private Wallet $wallet;

    private User $user;

    private array $data;

    public function execute(array $data)
    {
        $this->data = $data;
        $this->user = request()->user();

        throw_if(
            !$this->wallet = Wallet::where('user_id', $this->user->id)->first(),
            new ModelNotFoundException('User wallet not found.')
        );

        throw_if(
            $this->wallet->balance < $data['amount'],
            new IncompleteRequestException('Insufficient funds.')
        );

        $this->setPayload();

        try {
            DB::transaction(function () {
                $this->data['status'] = Status::SUCCESSFUL;
                $this->updateWallet();
                $this->recordTransaction();
            });
        } catch (Exception $e) {
            $this->data['status'] = Status::FAILED;

            // Record the transaction history after failed creation
            dispatch(new RecordTransaction(getTransactionData($this->data)));

            throw $e;
        }
    }

    private function updateWallet(): void
    {
        $this->wallet->last_balance = $this->wallet->balance;
        $this->wallet->balance -= (float) $this->data['amount'];

        // Update only if the version matches
        $updated = UpdateWalletAction::execute($this->wallet);

        if (!$updated) {
            throw (new IncompleteRequestException('Failed to purchase airtime, please try again'));
        }

        // Since the transaction went well, update the new balance
        $this->data['wallet_balance'] = $this->wallet->balance;
    }

    private function recordTransaction(): void
    {
        CreateTransactionAction::execute(getTransactionData($this->data));
    }

    private function setPayload(): void
    {
        $this->data['user_id'] = $this->user->id;
        $this->data['wallet_id'] = $this->wallet->id;
        $this->data['wallet_balance'] = $this->wallet->balance;
        $this->data['status'] = Status::PENDING;
        $this->data['request_type'] = RequestType::DEBIT;
        $this->data['transaction_type'] = TransactionType::AIRTIME;
        $this->data['notes'] = 'Purchase airtime';
        $this->data['network_provider_id'] = $this->data['providerId'];
        $this->data['recipient'] = $this->data['phoneNumber'];
    }
}
