<?php

namespace App\DTO;

use App\Entity\EntityInterface;
use App\Serializer\AccessGroup;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Attribute\Ignore;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;


final class UserDTO implements DTOInterface
{

    #[Groups([
        AccessGroup::USER_CREATE,
    ])]
    #[NotBlank(groups: [AccessGroup::USER_CREATE])]
    #[Email(groups: [AccessGroup::USER_CREATE])]

    public string $email;

    #[Groups([
        AccessGroup::USER_CREATE,
    ])]
    #[NotBlank(groups: [AccessGroup::USER_CREATE])]
    #[Assert\Length(min: 8, groups: [AccessGroup::USER_CREATE])]
    #[Assert\PasswordStrength]
    public string $password;

    #[Groups([
        AccessGroup::USER_CREATE,
    ])]
    #[NotBlank(groups: [AccessGroup::USER_CREATE])]
    public string $name;

    #[Ignore]
    public function getEntityObject(): EntityInterface
    {
        return new User();
    }
}
