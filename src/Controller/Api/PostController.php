<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\DTO\PostDTO;
use App\Entity\Post;
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

    #[Route('posts/{post}', name: 'show', methods: 'GET')]
    public function show(Post $post): JsonResponse
    {
        return $this->json($this->postManager->mapToModel($post, AccessGroup::POST_SHOW), HttpResponse::HTTP_OK);
    }

    #[Route('posts/update/{post}', name: 'update', methods: 'PUT')]
    public function update(
        #[MapRequestPayload(
            serializationContext: [
                'groups' => [AccessGroup::POST_UPDATE],
            ],
            validationGroups: [AccessGroup::POST_UPDATE]
        )]
        PostDTO $postDTO,
        Post $post
    ): JsonResponse {
        $this->denyAccessUnlessGranted('POST_UPDATE', $post);

        return $this->json($this->postManager->update($post, $postDTO), HttpResponse::HTTP_OK);
    }

    #[Route('posts/delete/{post}', name: 'delete', methods: 'DELETE')]
    public function delete(Post $post): JsonResponse
    {
        $this->denyAccessUnlessGranted('POST_DELETE', $post);
        $this->postManager->delete($post);
        return $this->json(null, HttpResponse::HTTP_NO_CONTENT);
    }
}
