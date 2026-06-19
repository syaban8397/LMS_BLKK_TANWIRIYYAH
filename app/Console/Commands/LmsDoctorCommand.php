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
            $this->checkSessionSecurity(),
            $this->checkDatabase(),
            $this->checkMigrations(),
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
        $probePaths = [
            $link . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'Logo.png',
            $link . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'logo.png',
        ];

        $ok = collect($probePaths)->contains(fn (string $path) => file_exists($path));

        if (! $ok) {
            $ok = (is_link($link) || is_dir($link)) && is_dir(storage_path('app/public'));
        }

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
            'sidebar-bg.png',
            'logo-kemnaker.png',
            'logo-kemnaker-mark.png',
            'logo-pelatihan-vokasi.png',
            'logo-indonesia-skills.png',
            'logo-siapkerja.png',
            'page2-watermark.png',
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
    private function checkSessionSecurity(): array
    {
        if (! app()->environment('production')) {
            return $this->report(
                'Session security (SESSION_ENCRYPT)',
                true,
                'Environment non-production — lewati.'
            );
        }

        $encrypt = (bool) config('session.encrypt');
        $secure = (bool) config('session.secure');

        $ok = $encrypt && $secure;

        return $this->report(
            'Session security (SESSION_ENCRYPT + SESSION_SECURE_COOKIE)',
            $ok,
            $ok
                ? 'Session terenkripsi & cookie secure aktif.'
                : 'Production wajib SESSION_ENCRYPT=true dan SESSION_SECURE_COOKIE=true (HTTPS).'
        );
    }

    /**
     * @return array{ok: bool, label: string, detail: string}
     */
    private function checkDatabase(): array
    {
        try {
            \Illuminate\Support\Facades\DB::connection()->getPdo();

            return $this->report(
                'Database connection',
                true,
                'Terhubung (' . config('database.default') . ').'
            );
        } catch (\Throwable $e) {
            return $this->report(
                'Database connection',
                false,
                'Gagal: periksa DB_* di .env'
            );
        }
    }

    /**
     * @return array{ok: bool, label: string, detail: string}
     */
    private function checkMigrations(): array
    {
        try {
            $files = collect(File::glob(database_path('migrations/*.php')))
                ->map(fn (string $path) => pathinfo($path, PATHINFO_FILENAME))
                ->values();

            $ran = collect(\Illuminate\Support\Facades\DB::table('migrations')->pluck('migration'));
            $pending = $files->diff($ran);
            $ok = $pending->isEmpty();
            $total = $files->count();
            $ranCount = $total - $pending->count();

            return $this->report(
                'Database migrations',
                $ok,
                $ok
                    ? "{$ranCount}/{$total} migration dijalankan."
                    : 'Pending: ' . $pending->take(3)->implode(', ') . ($pending->count() > 3 ? '…' : '') . ' — jalankan: php artisan migrate --force'
            );
        } catch (\Throwable) {
            return $this->report(
                'Database migrations',
                false,
                'Tidak dapat memeriksa — pastikan database aktif.'
            );
        }
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
