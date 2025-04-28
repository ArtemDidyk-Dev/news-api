<?php

namespace App\DTO\ListDTO;
use App\DTO\PostDTO;
use App\Serializer\AccessGroup;
use Symfony\Component\Serializer\Attribute\Groups;
final class PostListDTO implements DTOListInterface
{

    #[Groups([
        AccessGroup::POST_SHOW,
    ])]
    /** @var array<int, PostDTO> $data */
    public ?array $data = [];

    #[Groups([
        AccessGroup::POST_SHOW,
    ])]
    public MetaDTO $meta;
}
