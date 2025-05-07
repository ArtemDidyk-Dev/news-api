<?php

declare(strict_types=1);

namespace App\DTO;

use App\Entity\EntityInterface;
use App\Entity\Post;
use App\Serializer\AccessGroup;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Attribute\Ignore;

final class PostDTO implements DTOInterface
{
    #[Groups([AccessGroup::POST_SHOW, AccessGroup::POST_CREATE, AccessGroup::POST_UPDATE])]
    public ?int $id;

    #[Groups([AccessGroup::POST_SHOW, AccessGroup::POST_CREATE, AccessGroup::POST_UPDATE])]
    public string $title;

    #[Groups([AccessGroup::POST_SHOW, AccessGroup::POST_CREATE, AccessGroup::POST_UPDATE])]
    public string $content;

    #[Groups([AccessGroup::POST_CREATE, AccessGroup::POST_SHOW, AccessGroup::POST_UPDATE])]
    public UserDTO $author;

    #[Ignore]
    public function getEntityObject(): EntityInterface
    {
        return new Post();
    }
}
