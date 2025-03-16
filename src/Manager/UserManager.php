<?php

declare(strict_types=1);

namespace App\Manager;

use App\Builder\UserEntityBuilder;
use App\DTO\UserDTO;
use Doctrine\ORM\EntityManagerInterface;

final readonly class UserManager
{
    public function __construct(
        private EntityManagerInterface $em,
        private UserEntityBuilder $userEntityBuilder,
    ) {
    }

    public function create(UserDTO $userDTO): void
    {
        $user = $this->userEntityBuilder->buildFromDTO($userDTO);
        $this->em->persist($user);
        $this->em->flush();
    }
}
