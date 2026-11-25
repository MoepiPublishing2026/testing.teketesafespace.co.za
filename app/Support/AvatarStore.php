<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class AvatarStore
{
    public const DIR = 'avatars';

    public const MAX_BYTES = 2 * 1024 * 1024;

    public const ALLOWED = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/gif' => 'gif',
        'image/webp' => 'webp',
    ];

    public function store(UploadedFile $file): string
    {
        return $this->storeFromPath((string) $file->getRealPath());
    }

    public function storeFromPath(string $source): string
    {
        $mime = (new \finfo(FILEINFO_MIME_TYPE))->file($source) ?: '';

        if (! isset(self::ALLOWED[$mime])) {
            $this->fail('The file must be a JPG, PNG, GIF or WebP image.');
        }

        if (filesize($source) > self::MAX_BYTES) {
            $this->fail('The image may not be greater than 2MB.');
        }

        try {
            return app(AttachmentStore::class)->storeFromPath($source, directory: self::DIR);
        } catch (ValidationException $e) {
            $this->fail($e->errors()['image'][0] ?? 'This image could not be processed. Please try a different one.');
        }
    }

    public function isPrivate(?string $path): bool
    {
        $path = $this->normalize((string) $path);

        return $path !== '' && str_starts_with($path, self::DIR.'/');
    }

    public function locate(?string $path): ?string
    {
        $path = $this->normalize((string) $path);

        if ($path === '' || ! $this->isPrivate($path)) {
            return null;
        }

        $disk = Storage::disk(config('attachments.disk'));
        $diskRoot = realpath($disk->path(''));
        $root = realpath($disk->path(self::DIR));
        $stored = $disk->path($path);
        $real = ! is_link($stored) ? realpath($stored) : false;

        if ($diskRoot === false || $root === false || ! str_starts_with($root, $diskRoot.DIRECTORY_SEPARATOR)) {
            return null;
        }

        return ($real !== false && is_file($real) && str_starts_with($real, $root.DIRECTORY_SEPARATOR))
            ? $real
            : null;
    }

    public function delete(?string $path): void
    {
        $path = $this->normalize((string) $path);

        if ($path === '') {
            return;
        }

        if ($this->isPrivate($path)) {
            Storage::disk(config('attachments.disk'))->delete($path);

            return;
        }

        foreach ($this->legacyFiles($path) as $file) {
            @unlink($file);
        }
    }

    /** @return string[] */
    public function legacyFiles(string $path): array
    {
        $path = $this->normalize($path);

        if ($path === '' || $this->isPrivate($path)) {
            return [];
        }

        $found = [];

        foreach (self::legacyRoots() as $root => $layout) {
            $rootReal = realpath($root);

            if ($rootReal === false) {
                continue;
            }

            $relative = $layout === 'flat' ? basename($path) : $path;
            $source = $rootReal.DIRECTORY_SEPARATOR.str_replace('/', DIRECTORY_SEPARATOR, $relative);
            $real = ! is_link($source) ? realpath($source) : false;

            if ($real !== false && is_file($real) && str_starts_with($real, $rootReal.DIRECTORY_SEPARATOR)) {
                $found[$real] = $real;
            }
        }

        return array_values($found);
    }

    /** @return string[] */
    public function legacyDirectories(): array
    {
        $dirs = [];

        foreach (self::legacyRoots() as $root => $layout) {
            $dirs[] = $layout === 'flat' ? $root : $root.DIRECTORY_SEPARATOR.'profile_pictures';
        }

        return $dirs;
    }

    public static function legacyRoots(): array
    {
        return [
            storage_path('app/public') => 'nested',
            public_path('storage') => 'nested',
            public_path('public_old/storage') => 'nested',
            public_path('profile_pictures') => 'flat',
            public_path('pictures/profile_pictures') => 'flat',
            storage_path('profile_pictures') => 'flat',
        ];
    }

    private function normalize(string $path): string
    {
        $path = str_replace('\\', '/', trim($path));
        $path = preg_replace('#^public/#', '', $path);
        $path = ltrim((string) $path, '/');

        if ($path === '' || str_contains($path, '..') || str_contains($path, "\0")) {
            return '';
        }

        return $path;
    }

    private function fail(string $message): never
    {
        throw ValidationException::withMessages(['profile_picture' => $message]);
    }
}
