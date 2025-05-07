<?php

declare(strict_types=1);

namespace App\DTO;

use App\Entity\EntityInterface;
use App\Entity\User;
use App\Serializer\AccessGroup;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Attribute\Ignore;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

final class UserDTO implements DTOInterface
{
    #[Groups([AccessGroup::USER_SHOW, AccessGroup::POST_CREATE, AccessGroup::POST_SHOW, AccessGroup::POST_UPDATE])]
    public ?int $id;

    #[Groups([AccessGroup::USER_CREATE, AccessGroup::POST_CREATE, AccessGroup::POST_SHOW, AccessGroup::POST_UPDATE])]
    #[NotBlank(groups: [AccessGroup::USER_CREATE])]
    #[Email(groups: [AccessGroup::USER_CREATE, AccessGroup::USER_SHOW, AccessGroup::POST_UPDATE])]
    public string $email;

    #[Groups([AccessGroup::USER_CREATE])]
    #[NotBlank(groups: [AccessGroup::USER_CREATE])]
    #[Assert\Length(min: 8, groups: [AccessGroup::USER_CREATE])]
    #[Assert\PasswordStrength]
    public string $password;

    #[Groups([AccessGroup::USER_CREATE, AccessGroup::POST_CREATE, AccessGroup::POST_SHOW, AccessGroup::POST_UPDATE])]
    #[NotBlank(groups: [AccessGroup::USER_CREATE, AccessGroup::USER_SHOW])]
    public string $name;

    #[Ignore]
    public function getEntityObject(): EntityInterface
    {
        return new User();
    }
}
