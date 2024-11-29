<?php

namespace App\Enums;

enum TransactionType: String
{
    case AIRTIME = 'airtime';
    case DATA = 'data';
    case ELECTRICITY = 'electricity';
    case FUND_WALLET = 'fund_wallet';

    public function label(): string
    {
        return static::getLabel($this);
    }

    public static function getLabel(self $value): string
    {
        return match ($value) {
            TransactionType::AIRTIME => 'Airtime',
            TransactionType::DATA => 'Data',
            TransactionType::ELECTRICITY => 'Electricity',
            TransactionType::FUND_WALLET => 'Fund Wallet',
            default => 'Unknown',
        };
    }
}
