<?php

namespace App\Repositories\User;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

interface UserRepository
{
    public function getAllUsers(): LengthAwarePaginator;
    public function getUser(int $id): User;
    public function createUser(array $data): User;
    public function updateUser(int $id, array $data): User;
    public function deleteUser(int $id): void;
}
