<?php

namespace App\Controller\Api;

use App\DTO\PostDTO;
use App\Entity\Post;
use App\Serializer\AccessGroup;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

#[Route(name: 'api_posts_', format: 'json')]
class PostController extends AbstractController
{

    #[Route('posts/create', name: 'create', methods: 'POST')]
    public function create(
        #[MapRequestPayload (
            serializationContext: [
                'groups' => [AccessGroup::POST_CREATE],
            ],
            validationGroups: [AccessGroup::POST_CREATE]
        )]
        PostDTO $postDTO
    ): JsonResponse
    {
       dd($postDTO);
        return new JsonResponse(1);
    }

    #[Route('posts', name: 'index', methods: 'GET')]
    public function index(Request $request): JsonResponse
    {
        dd(1);
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
