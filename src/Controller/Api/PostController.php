<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\DTO\PostDTO;
use App\Manager\PostManager;
use App\Manager\PostManagerList;
use App\Serializer\AccessGroup;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'api_posts_', format: 'json')]
class PostController extends AbstractController
{
    public function __construct(
        private readonly PostManager $postManager,
        private readonly PostManagerList $postManagerList,
    ) {
    }

    #[Route('posts/create', name: 'create', methods: 'POST')]
    public function create(
        #[MapRequestPayload(
            serializationContext: [
                'groups' => [AccessGroup::POST_CREATE],
            ],
            validationGroups: [AccessGroup::POST_CREATE]
        )]
        PostDTO $postDTO
    ): JsonResponse {
        return $this->json($this->postManager->create($postDTO), HttpResponse::HTTP_CREATED);
    }

    #[Route('posts', name: 'index', methods: 'GET')]
    public function index(Request $request): JsonResponse
    {
        $posts = $this->postManagerList->list($request);
        return $this->json($posts, HttpResponse::HTTP_OK);
    }

    //    #[Route('posts/{post}', name: 'show', methods: 'GET')]
    //    public function show(Post $post): JsonResponse
    //    {
    //        return new JsonResponse(1);
    //    }
    //
    //
    //    public function update(Post $post): JsonResponse
    //    {
    //        return new JsonResponse(1);
    //    }
}
