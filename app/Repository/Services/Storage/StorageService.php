<?php

namespace App\Repository\Services\Storage;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class StorageService
{
    protected string $fileExtension;
    protected string $fileBin;

    /**
     * Construct storage.
     *
     * @param Storage $storage
     */
    public function __construct(Storage $storage)
    {
        $this->storage = $storage::disk('public');
    }

    /**
     * Decode base64 file.
     * @param string $base64File
     */
    public function decodeFile(string $base64File): self
    {
        $base64Data = explode(',', $base64File)[1];

        $imgdata = base64_decode($base64Data);

        $f = finfo_open();

        $mime_type = finfo_buffer($f, $imgdata, FILEINFO_MIME_TYPE);

        $this->fileExtension = explode('/', $mime_type)[1];

        $this->fileBin = base64_decode($base64Data);

        return $this;
    }

    public function save($path, $name): array
    {
        $fileUrl = $this->storage->url($path);

        $this->storage->put($path . DIRECTORY_SEPARATOR . $name . '.' . $this->fileExtension, $this->fileBin);

        return [
            'path' => $path . DIRECTORY_SEPARATOR,
            'url'  => $fileUrl . DIRECTORY_SEPARATOR . $name . '.' . $this->fileExtension,
        ];
    }
}
