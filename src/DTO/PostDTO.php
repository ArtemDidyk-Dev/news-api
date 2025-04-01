<?php

namespace App\DTO;

use App\Entity\EntityInterface;
use App\Entity\Post;
use App\Serializer\AccessGroup;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Attribute\Ignore;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;
final class PostDTO implements DTOInterface
{
    #[Groups(AccessGroup::POST_SHOW)]
    public ?int $id;

    #[Groups([AccessGroup::POST_SHOW, AccessGroup::POST_CREATE])]
    public string $title;

    #[Groups([AccessGroup::POST_SHOW, AccessGroup::POST_CREATE])]
    public string $content;

    #[Ignore] public function getEntityObject(): EntityInterface
    {
        return new Post();
    }
}
