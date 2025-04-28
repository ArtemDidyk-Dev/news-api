<?php

namespace App\Manager;

use App\DTO\ListDTO\PostListDTO;
use App\Entity\Post;
use App\Serializer\AccessGroup;
use App\Services\PaginationService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Random\RandomException;
use Symfony\Component\HttpFoundation\Request;

class PostManagerList
{
    use AutoMapper;
    public function __construct(
        private readonly PaginationService $paginationService,
        private EntityManagerInterface $em,
    )
    {
    }

    /**
     * @throws \ReflectionException
     * @throws RandomException
     */
    public function list(Request $request): PostListDTO
    {
        $queryBuilder = $this->getQbWithFilter($request);
        $paginationResult = $this->paginationService->handlePagination($queryBuilder, $request);
        $paginator = $paginationResult['paginator'];
        $posts = iterator_to_array($paginator->getIterator());
        $postListDTO = new  PostListDTO();
        foreach ($posts as $post) {
            $postListDTO->data[] = $this->mapToModel($post, AccessGroup::POST_SHOW);
        }
        $postListDTO->meta = $paginationResult['meta'];
        return $postListDTO;

    }

    private function getQbWithFilter(Request $request): QueryBuilder
    {
        return $this->em->getRepository(Post::class)->createQueryBuilder('posts');
    }

}
