<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Services\PhotoService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'api_photo_', format: 'json')]
class PhotoController extends AbstractController
{

    public function __construct(
        private readonly PhotoService $photoService,
    )
    {
    }

    #[Route('photo/upload', name: 'upload', methods: 'POST')]
    public function upload(Request $request): JsonResponse
    {
        try {
            $photo = $this->photoService->upload($request->files->get('file'));
            return new JsonResponse($photo);
        }
        catch (\Exception $exception) {
            return $this->json(['error' => $exception->getMessage()], 500);
        }
    }
}
