<?php

namespace App\DTO;

use App\Entity\EntityInterface;
use App\Entity\Post;
use App\Serializer\AccessGroup;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Attribute\Ignore;
final class PostDTO implements DTOInterface
{
    #[Groups([AccessGroup::POST_SHOW, AccessGroup::POST_CREATE])]
    public ?int $id;

    #[Groups([AccessGroup::POST_SHOW, AccessGroup::POST_CREATE])]
    public string $title;

    #[Groups([AccessGroup::POST_SHOW, AccessGroup::POST_CREATE])]
    public string $content;

    #[Groups([
        AccessGroup::POST_CREATE,
        AccessGroup::POST_SHOW,
    ])]
    public UserDTO $author;

    #[Ignore] public function getEntityObject(): EntityInterface
    {
        return new Post();
    }
}
