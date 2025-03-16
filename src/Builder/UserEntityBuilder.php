<?php

namespace App\Builder;

use App\DTO\UserDTO;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final readonly class UserEntityBuilder
{
    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }

    public function buildFromDTO(UserDTO $userDTO): User
    {
        $user = new User();
        $user
            ->setEmail($userDTO->email)
            ->setName($userDTO->name);
        $user->setPassword($this->hasher->hashPassword($user, $userDTO->password));
        return $user;

    }
}
