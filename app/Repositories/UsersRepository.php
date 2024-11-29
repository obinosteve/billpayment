<?php

namespace App\Repositories;

use App\Models\User;

class UsersRepository
{
    public function getByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }
}
