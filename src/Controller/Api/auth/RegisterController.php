<?php

declare(strict_types=1);

namespace App\Controller\Api\auth;

use App\DTO\UserDTO;
use App\Manager\UserManager;
use App\Serializer\AccessGroup;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'api_')]
class RegisterController extends AbstractController
{
    public function __construct(
        private readonly UserManager $userManager,
    ) {
    }

    #[Route('register', name: 'register', methods: 'POST', format: 'json')]
    public function __invoke(
        #[MapRequestPayload(
            serializationContext: [
                'groups' => [AccessGroup::USER_CREATE],
            ],
            validationGroups: [AccessGroup::USER_CREATE]
        )]
        UserDTO $registerUserDTO
    ): JsonResponse {
        $this->userManager->create($registerUserDTO);
        return $this->json([
            'data' => 'User Created',
        ], HttpResponse::HTTP_CREATED);
    }
}
