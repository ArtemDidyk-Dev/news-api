<?php

namespace App\Builder;

use App\DTO\PostDTO;
use App\Entity\Post;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


final readonly class PostEntityBuilder
{
    public function __construct(
        private Security $securityUser,
    )
    {
    }

    public function buildFromDTO(PostDTO $postDTO): Post
    {
        $author = $this->securityUser->getUser();
        if ($author === null) {
            throw new NotFoundHttpException('User not found');
        }
        $post = new Post();
        $post
            ->setAuthor($author)
            ->setTitle($postDTO->title)
            ->setContent($postDTO->content);
        return $post;
    }

}
