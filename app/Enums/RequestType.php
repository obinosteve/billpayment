<?php

namespace App\Enums;

enum RequestType: String
{
    case DEBIT = 'debit';
    case CREDIT = 'credit';

    public function label(): string
    {
        return static::getLabel($this);
    }

    public static function getLabel(self $value): string
    {
        return match ($value) {
            RequestType::DEBIT => 'Debit',
            RequestType::CREDIT => 'Credit',
            default => 'Unknown',
        };
    }
}
