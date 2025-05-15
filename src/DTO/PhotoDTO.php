<?php

declare(strict_types=1);

namespace App\DTO;

use App\Entity\EntityInterface;
use App\Entity\Photo;
use App\Serializer\AccessGroup;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Attribute\Ignore;

final class PhotoDTO implements DTOInterface
{
    #[Groups([AccessGroup::POST_CREATE, AccessGroup::POST_SHOW, AccessGroup::PHOTO_SHOW])]
    public ?int $id;

    #[Ignore]
    public function getEntityObject(): EntityInterface
    {
        return new Photo();
    }
}
