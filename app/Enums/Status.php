<?php

namespace App\Enums;

enum Status: String
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case SUSPENDED = 'suspended';
    case DELETED = 'deleted';
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    case SETTLED = 'settled';
    case FAILED = 'failed';
    case PENDING_REFUND = 'pending_refund';
    case PENDING_CHARGE = 'pending_charge';
    case REFUNDED = 'refunded';
    case SUCCESSFUL = 'successful';
    case ENABLED = 'enabled';
    case DISABLED = 'disabled';

    public function label(): string
    {
        return static::getLabel($this);
    }

    public static function getLabel(self $value): string
    {
        return match ($value) {
            Status::ACTIVE => 'Active',
            Status::INACTIVE => 'Inactive',
            Status::SUSPENDED => 'Suspended',
            Status::DELETED => 'Deleted',
            Status::PENDING => 'Pending',
            Status::APPROVED => 'Approved',
            Status::REJECTED => 'Rejected',
            Status::SETTLED => 'Settled',
            Status::FAILED => 'Failed',
            Status::PENDING_REFUND => 'Pending Refund',
            Status::PENDING_CHARGE => 'Pending Charge',
            Status::REFUNDED => 'Refunded',
            Status::SUCCESSFUL => 'Successful',
            Status::ENABLED => 'Enabled',
            Status::DISABLED => 'Disabled',

            default => 'Unknown',
        };
    }
}
