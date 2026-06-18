<?php

namespace App\Support;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class PasswordResetToken
{
    private const CACHE_PREFIX = 'password_reset:';

    public static function ttlMinutes(): int
    {
        return (int) config('auth.password_reset_token_ttl', 15);
    }

    public static function create(int $userId): string
    {
        $token = Str::random(64);

        Cache::put(
            self::CACHE_PREFIX . $token,
            $userId,
            now()->addMinutes(self::ttlMinutes())
        );

        return $token;
    }

    public static function userIdFor(string $token): ?int
    {
        $userId = Cache::get(self::CACHE_PREFIX . $token);

        return is_numeric($userId) ? (int) $userId : null;
    }

    public static function consume(string $token): ?int
    {
        $userId = self::userIdFor($token);

        if ($userId !== null) {
            Cache::forget(self::CACHE_PREFIX . $token);
        }

        return $userId;
    }

    public static function invalidate(string $token): void
    {
        Cache::forget(self::CACHE_PREFIX . $token);
    }
}
