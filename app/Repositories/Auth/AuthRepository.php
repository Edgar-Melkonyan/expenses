<?php

namespace App\Repositories\Auth;

use App\Models\User;

interface AuthRepository
{
    public function login(User $user): array ;
    public function logout(User $user): void ;
}
