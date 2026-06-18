<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class LmsDoctorCommand extends Command
{
    protected $signature = 'lms:doctor';

    protected $description = 'Periksa kesiapan deploy LMS BLKK (aset, storage, environment)';

    public function handle(): int
    {
        $this->info('LMS BLKK Tanwiriyyah — Pemeriksaan Kesiapan');
        $this->newLine();

        $checks = [
            $this->checkAppKey(),
            $this->checkDebugMode(),
            $this->checkStorageLink(),
            $this->checkLogo(),
            $this->checkCertificateAssets(),
            $this->checkBuildAssets(),
        ];

        $this->newLine();

        $failed = collect($checks)->where('ok', false)->count();

        if ($failed === 0) {
            $this->info('Semua pemeriksaan lulus. Sistem siap deploy.');

            return self::SUCCESS;
        }

        $this->warn("{$failed} pemeriksaan perlu perhatian. Lihat daftar di atas.");

        return self::FAILURE;
    }

    /**
     * @return array{ok: bool, label: string, detail: string}
     */
    private function checkAppKey(): array
    {
        $ok = filled(config('app.key'));

        return $this->report(
            'Application key (APP_KEY)',
            $ok,
            $ok ? 'Terisi.' : 'Jalankan: php artisan key:generate'
        );
    }

    /**
     * @return array{ok: bool, label: string, detail: string}
     */
    private function checkDebugMode(): array
    {
        if (! app()->environment('production')) {
            return $this->report(
                'Debug mode (APP_DEBUG)',
                true,
                'Environment non-production — lewati.'
            );
        }

        $ok = ! config('app.debug');

        return $this->report(
            'Debug mode (APP_DEBUG)',
            $ok,
            $ok ? 'APP_DEBUG=false.' : 'Production wajib APP_DEBUG=false.'
        );
    }

    /**
     * @return array{ok: bool, label: string, detail: string}
     */
    private function checkStorageLink(): array
    {
        $link = public_path('storage');
        $ok = is_link($link) || File::isDirectory($link);

        return $this->report(
            'Storage symlink (public/storage)',
            $ok,
            $ok ? 'Aktif.' : 'Jalankan: php artisan storage:link'
        );
    }

    /**
     * @return array{ok: bool, label: string, detail: string}
     */
    private function checkLogo(): array
    {
        $paths = [
            storage_path('app/public/images/Logo.png'),
            storage_path('app/public/images/logo.png'),
        ];

        $found = collect($paths)->first(fn ($path) => File::exists($path));

        return $this->report(
            'Logo instansi',
            (bool) $found,
            $found
                ? basename($found) . ' ditemukan.'
                : 'Upload ke storage/app/public/images/Logo.png'
        );
    }

    /**
     * @return array{ok: bool, label: string, detail: string}
     */
    private function checkCertificateAssets(): array
    {
        $required = [
            'logo-kemnaker.png',
            'logo-blkk.png',
        ];

        $missing = collect($required)->filter(
            fn ($file) => ! File::exists(public_path('images/certificates/' . $file))
        );

        $ok = $missing->isEmpty();

        return $this->report(
            'Asset template sertifikat',
            $ok,
            $ok
                ? 'File utama tersedia.'
                : 'Kurang: ' . $missing->implode(', ')
        );
    }

    /**
     * @return array{ok: bool, label: string, detail: string}
     */
    private function checkBuildAssets(): array
    {
        $manifest = public_path('build/manifest.json');
        $ok = File::exists($manifest);

        return $this->report(
            'Frontend build (Vite)',
            $ok,
            $ok ? 'manifest.json ditemukan.' : 'Jalankan: npm ci && npm run build'
        );
    }

    /**
     * @return array{ok: bool, label: string, detail: string}
     */
    private function report(string $label, bool $ok, string $detail): array
    {
        $this->line(sprintf(
            ' [%s] %s — %s',
            $ok ? 'OK' : '!!',
            $label,
            $detail
        ));

        return compact('ok', 'label', 'detail');
    }
}
