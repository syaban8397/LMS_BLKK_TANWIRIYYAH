<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class SystemSetting extends Model
{
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

    public static function current(): self
    {
        return static::firstOrCreate([], [
            'default_theme' => 'light',
            'default_locale' => 'id',
        ]);
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
