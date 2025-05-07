<?php

declare(strict_types=1);

namespace App\Manager;

use App\DTO\ListDTO\PostListDTO;
use App\Entity\Post;
use App\Serializer\AccessGroup;
use App\Services\PaginationService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\HttpFoundation\Request;

class PostManagerList
{
    use AutoMapper;

    public function __construct(
        private readonly PaginationService $paginationService,
        private EntityManagerInterface $em,
    ) {
    }

    public function list(Request $request): PostListDTO
    {
        $queryBuilder = $this->getQbWithFilter($request);
        $paginationResult = $this->paginationService->handlePagination($queryBuilder, $request);
        $paginator = $paginationResult['paginator'];
        $posts = iterator_to_array($paginator->getIterator());
        $postListDTO = new PostListDTO();
        foreach ($posts as $post) {
            $postListDTO->data[] = $this->mapToModel($post, AccessGroup::POST_SHOW);
        }
        $postListDTO->meta = $paginationResult['meta'];

        return $postListDTO;

    }

    private function getQbWithFilter(Request $request): QueryBuilder
    {
        $qb = $this->em->getRepository(Post::class)->createQueryBuilder('posts');
        $this->searchFilter($qb, $request);
        $this->applySorting($qb, $request);
        return $qb;
    }

    private function searchFilter(QueryBuilder $qb, Request $request): QueryBuilder
    {
        if ($request->get('search')) {
            $search = $request->get('search');
            $qb->where('posts.title  LIKE :search OR posts.content LIKE :search');
            $qb->setParameter('search', "%{$search}%");
        }
        return $qb;
    }

    private function applySorting(QueryBuilder $queryBuilder, Request $request): void
    {
        $sortField = $request->get('sort');
        $sortOrder = $request->get('order', 'asc');
        $validFields = ['id', 'title', 'content'];
        $validDirections = ['asc', 'desc'];
        if (! in_array($sortOrder, $validDirections, true)) {
            $sortOrder = 'asc';
        }

        if (in_array($sortField, $validFields, true)) {
            $queryBuilder->orderBy('posts.' . $sortField, strtoupper($sortOrder));
        } else {
            $queryBuilder->orderBy('posts.id', 'ASC');
        }
    }
}
