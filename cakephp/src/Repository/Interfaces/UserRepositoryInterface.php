<?php
declare(strict_types=1);

namespace App\Repository\Interfaces;

interface UserRepositoryInterface
{
    public function getAllUsers(): array;

    public function createUser(array $data): bool;
}
