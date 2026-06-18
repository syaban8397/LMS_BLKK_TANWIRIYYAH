<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;

class SecureStorage
{
    public const DISK = 'local';

    public const LEGACY_DISK = 'public';

    public static function disk(): string
    {
        return self::DISK;
    }

    public static function normalizePath(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        $path = trim($path);

        if (str_contains($path, '://')) {
            $path = parse_url($path, PHP_URL_PATH) ?? $path;
        }

        $path = ltrim($path, '/');

        if (str_starts_with($path, 'storage/')) {
            $path = substr($path, strlen('storage/'));
        }

        if (str_starts_with($path, 'app/public/')) {
            $path = substr($path, strlen('app/public/'));
        }

        if (str_starts_with($path, 'app/private/')) {
            $path = substr($path, strlen('app/private/'));
        }

        return $path !== '' ? $path : null;
    }

    public static function exists(?string $path): bool
    {
        $path = self::normalizePath($path);

        if (!$path) {
            return false;
        }

        return Storage::disk(self::DISK)->exists($path)
            || Storage::disk(self::LEGACY_DISK)->exists($path);
    }

    public static function path(?string $path): ?string
    {
        $path = self::normalizePath($path);

        if (!$path) {
            return null;
        }

        if (Storage::disk(self::DISK)->exists($path)) {
            return Storage::disk(self::DISK)->path($path);
        }

        if (Storage::disk(self::LEGACY_DISK)->exists($path)) {
            return Storage::disk(self::LEGACY_DISK)->path($path);
        }

        return null;
    }

    public static function get(?string $path): ?string
    {
        $path = self::normalizePath($path);

        if (!$path) {
            return null;
        }

        if (Storage::disk(self::DISK)->exists($path)) {
            return Storage::disk(self::DISK)->get($path);
        }

        if (Storage::disk(self::LEGACY_DISK)->exists($path)) {
            return Storage::disk(self::LEGACY_DISK)->get($path);
        }

        return null;
    }

    public static function put(string $path, $contents): void
    {
        Storage::disk(self::DISK)->put($path, $contents);
    }

    public static function delete(?string $path): void
    {
        $path = self::normalizePath($path);

        if (!$path) {
            return;
        }

        if (Storage::disk(self::DISK)->exists($path)) {
            Storage::disk(self::DISK)->delete($path);
        }

        if (Storage::disk(self::LEGACY_DISK)->exists($path)) {
            Storage::disk(self::LEGACY_DISK)->delete($path);
        }
    }

    public static function storeUploadedFile($file, string $directory): string
    {
        $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());

        return $file->storeAs($directory, $fileName, self::DISK);
    }
}
