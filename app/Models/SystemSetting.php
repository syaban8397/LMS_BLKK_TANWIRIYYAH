<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;

class SystemSetting extends Model
{
    private const CACHE_KEY = 'system_settings.current';

    protected $fillable = [
        'app_display_name',
        'default_theme',
        'default_locale',
        'mail_mailer',
        'mail_host',
        'mail_port',
        'mail_username',
        'mail_password',
        'mail_encryption',
        'mail_from_address',
        'mail_from_name',
    ];

    protected static function booted(): void
    {
        static::saved(fn () => static::clearCache());
        static::deleted(fn () => static::clearCache());
    }

    public static function clearCache(): void
    {
        Cache::forget(static::CACHE_KEY);
    }

    public static function current(): self
    {
        $cachedId = Cache::get(static::CACHE_KEY);

        if (is_int($cachedId) || (is_string($cachedId) && ctype_digit($cachedId))) {
            $settings = static::query()->find((int) $cachedId);
            if ($settings instanceof self) {
                return $settings;
            }
        }

        static::clearCache();

        $settings = static::firstOrCreate([], [
            'default_theme' => 'light',
            'default_locale' => 'id',
        ]);

        Cache::forever(static::CACHE_KEY, $settings->getKey());

        return $settings;
    }

    public static function applyMailConfig(): void
    {
        $settings = static::current();

        if (!$settings->mail_host) {
            return;
        }

        config([
            'mail.default' => $settings->mail_mailer ?: config('mail.default'),
            'mail.mailers.smtp.host' => $settings->mail_host,
            'mail.mailers.smtp.port' => $settings->mail_port ?: 587,
            'mail.mailers.smtp.username' => $settings->mail_username,
            'mail.mailers.smtp.encryption' => $settings->mail_encryption ?: null,
            'mail.from.address' => $settings->mail_from_address ?: config('mail.from.address'),
            'mail.from.name' => $settings->mail_from_name ?: config('mail.from.name'),
        ]);

        if ($settings->mail_password) {
            try {
                config(['mail.mailers.smtp.password' => Crypt::decryptString($settings->mail_password)]);
            } catch (\Throwable) {
                // Keep env password if stored value is invalid.
            }
        }
    }

    public function setMailPasswordAttribute(?string $value): void
    {
        if ($value === null || $value === '') {
            return;
        }

        $this->attributes['mail_password'] = Crypt::encryptString($value);
    }

    public function appName(): string
    {
        return $this->app_display_name ?: __('lms.app_name');
    }
}
