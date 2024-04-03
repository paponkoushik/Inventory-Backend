<?php

namespace App\Services\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait FileHandler
{
    protected $storagePrefix = 'public';
    protected $isOriginalName = false;

    public function storeFile(UploadedFile $file, $folder = 'avatar'): string
    {
        $name = $this->generateUploadingFileName($file);

        $file->storeAs("{$this->storagePrefix}/{$folder}", $name);

        return Storage::url($folder . '/' . $name);
    }

    private function generateUploadingFileName(UploadedFile $file): string
    {
        $name = $this->getDefaultName();

        if ($this->isOriginalName) {
            $name = Str::of($file->getClientOriginalName())
                ->replaceMatches("/[.].*/", '')
                ->snake()
                ->limit(30, '');
            $name = $name . "-" . uniqid();
        }

        return $name . "." . $file->getClientOriginalExtension();
    }

    private function getDefaultName(): string
    {
        return Str::random(40);
    }

}
