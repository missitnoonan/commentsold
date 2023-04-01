<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function load(array $user_data): bool {
        try {
            User::insert($user_data);

            return true;
        } catch (\Exception $exception) {
            // TODO: something better

            return false;
        }
    }
}
