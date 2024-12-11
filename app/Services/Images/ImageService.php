<?php

namespace App\Services\Images;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    private string $disk;

    private string $url;

    public function __construct($disk, $url)
    {
        $this->disk = $disk;
        $this->url = $url;
    }

    public function store(UploadedFile $uploadedFile): string
    {
        return Storage::disk($this->disk)->put($this->url, $uploadedFile);
    }

    public function existsImage(UploadedFile $uploadedFile): bool
    {
        return Storage::exists($uploadedFile);
    }

    public function delete(string $path): bool
    {
        return Storage::disk($this->disk)->delete($path);
    }
}
