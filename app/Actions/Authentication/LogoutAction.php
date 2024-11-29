<?php

namespace App\Actions\Authentication;

use App\Exceptions\IncompleteRequestException;

class LogoutAction
{
    public static function execute()
    {
        $user = request()->user();

        throw_if(
            !$user->tokens()->where('id', $user->currentAccessToken()->id)->delete(),
            new IncompleteRequestException('Unable to logout, please try again')
        );

        return true;
    }
}
