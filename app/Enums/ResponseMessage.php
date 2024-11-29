<?php

namespace App\Enums;

enum ResponseMessage: String
{
    case INCOMPLETE_REQUEST = 'incomplete_request';
    case PASSWORD_MISMATCH = 'password_mismatch';
    case BUSINESS_NOT_FOUND = 'business_not_found';
    case FAILED_VERIFICATION = 'failed_verification';
    case MISMATCH_VERIFICATION_CODE = 'code_mismatch';
    case FAILED_VALIDATION = 'failed_validation';
    case ACCOUNT_NOT_EXIST = 'account_not_exist';
    case ACCOUNT_SUSPENDED = 'account_suspended';
    case ACCOUNT_VERIFIED = 'account_verified';
    case EMAIL_NOT_VERIFIED = 'email_not_verified';
    case INVALID_LOGIN = 'invalid_login';

    public function label(): string
    {
        return static::getLabel($this);
    }

    public static function getLabel(self $value): string
    {
        return match ($value) {
            ResponseMessage::INCOMPLETE_REQUEST => 'Unable to complete your request, please try again',
            ResponseMessage::PASSWORD_MISMATCH => 'Your current password does not match the new password you provided',
            ResponseMessage::BUSINESS_NOT_FOUND => 'No business account found, please try again',
            ResponseMessage::FAILED_VERIFICATION => 'Account verification failed, please try again',
            ResponseMessage::MISMATCH_VERIFICATION_CODE => 'Verification code does not match or has expired',
            ResponseMessage::FAILED_VALIDATION => 'Validation failed',
            ResponseMessage::ACCOUNT_NOT_EXIST => 'Account does not exist',
            ResponseMessage::ACCOUNT_VERIFIED => 'Account already activated',
            ResponseMessage::ACCOUNT_SUSPENDED => 'Your account is suspended, please send a mail to billpayments@example.com',
            ResponseMessage::EMAIL_NOT_VERIFIED => 'Email not verified, please verify your email and try again',
            ResponseMessage::INVALID_LOGIN => 'Email or password incorrect',
            default => 'Unknown error occurred',
        };
    }
}
