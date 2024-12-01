<?php

namespace App\Actions\Wallet;

use App\Models\Wallet;
use Illuminate\Support\Facades\DB;

class UpdateWalletAction
{

    public static function execute(Wallet $wallet): bool
    {
        // If the wallet version has changed, then the update fails, 
        // which means another update might have happened
        return DB::table('wallets')
            ->where('id', $wallet->id)
            ->where('version', $wallet->version)
            ->update([
                'balance' => $wallet->balance,
                'version' => $wallet->version + 1,
                'last_balance' => $wallet->last_balance,
                'last_balance_update_at' => now()
            ]);
    }
}
