<?php

namespace App\Actions\Authentication;

use App\Enums\Status;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterAction
{
    public static function execute(array $data): User
    {
        $user = DB::transaction(function () use ($data) {
            $user = User::create([
                'first_name' => $data['firstName'],
                'last_name' => $data['lastName'],
                'email' => $data['email'],
                'phone' => $data['phoneNumber'],
                'password' => Hash::make($data['password']),
                'status' => Status::ACTIVE
            ]);

            $user->wallet()->create(['version' => 1]);

            return $user->load('wallet');
        });

        return $user;
    }
}
