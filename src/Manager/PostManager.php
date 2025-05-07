<?php

declare(strict_types=1);

namespace App\Manager;

use App\Builder\PostEntityBuilder;
use App\DTO\DTOInterface;
use App\DTO\PostDTO;
use App\Entity\Post;
use App\Serializer\AccessGroup;
use Doctrine\ORM\EntityManagerInterface;

final readonly class PostManager
{
    use AutoMapper;

    public function __construct(
        private PostEntityBuilder $postEntityBuilder,
        private EntityManagerInterface $em,
    ) {
    }

    public function create(PostDTO $postDTO): DTOInterface
    {
        $post = $this->postEntityBuilder->buildFromDTO($postDTO);
        $this->em->persist($post);
        $this->em->flush();

        return $this->mapToModel($post, AccessGroup::POST_CREATE);
    }

    public function update(Post $post, PostDTO $postDTO): DTOInterface
    {
        $postUpdate = $this->postEntityBuilder->updateFromDTO($post, $postDTO);
        $this->em->persist($postUpdate);
        $this->em->flush();
        return $this->mapToModel($postUpdate, AccessGroup::POST_UPDATE);
    }

    public function delete(Post $post): void
    {
        $this->em->remove($post);
        $this->em->flush();
    }
}
