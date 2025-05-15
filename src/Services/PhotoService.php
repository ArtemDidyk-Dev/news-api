<?php

declare(strict_types=1);

namespace App\Services;

use Symfony\Component\HttpFoundation\File\UploadedFile;

final readonly class PhotoService
{
    public function upload(UploadedFile $uploadedFile): void
    {
        dd($uploadedFile);
    }
}
