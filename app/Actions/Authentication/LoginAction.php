<?php

namespace App\Actions\Authentication;

use App\Models\User;
use App\Enums\ResponseMessage;
use App\Jobs\SaveUserLastLogin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\IncompleteRequestException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class LoginAction
{
    public static function execute(array $data): ?String
    {
        throw_if(
            !$user = User::where('email', $data['email'])->first(),
            new ModelNotFoundException(ResponseMessage::getLabel(ResponseMessage::ACCOUNT_NOT_EXIST))
        );

        throw_if(
            !$user->isActive(),
            new IncompleteRequestException(ResponseMessage::getLabel(ResponseMessage::ACCOUNT_SUSPENDED))
        );

        throw_if(
            !self::verifyPassword($data['password'], $user->password),
            new IncompleteRequestException(ResponseMessage::getLabel(ResponseMessage::INVALID_LOGIN))
        );

        $token = DB::transaction(function () use ($user) {
            // Delete all users token
            $user->tokens()->delete();

            // Create new token for the user
            $token = $user->createToken($user->email)->plainTextToken;

            // Save user last login 
            dispatch(new SaveUserLastLogin($user->id, now()))->afterCommit();

            return $token;
        });

        throw_if(
            !$token,
            new IncompleteRequestException(ResponseMessage::getLabel(ResponseMessage::INCOMPLETE_REQUEST))
        );

        return $token;
    }

    private static function verifyPassword(string $password, string $user_password): bool
    {
        return Hash::check($password, $user_password);
    }
}
