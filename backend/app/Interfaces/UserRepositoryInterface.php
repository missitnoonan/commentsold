<?php

namespace App\Interfaces;

interface UserRepositoryInterface
{
    public function load(array $user_data);
}
