<?php



namespace App\Support;



use App\Models\User;



class ReportUserFields
{
    public const EXCEL_TEXT_PREFIX = "\0";

    public static function headings(): array

    {

        return [

            'NIK',

            'Nama',

            'Email',

            'No. HP',

            'Jenis Kelamin',

            'Tempat Lahir',

            'Tanggal Lahir',

            'Alamat',

            'Bio',

            'Status Akun',

            'Persetujuan',

            'Terdaftar Pada',

            'Diperbarui Pada',

        ];

    }



    public static function row(User $user): array

    {

        return [

            $user->nik ?? '',

            $user->name ?? '',

            $user->email ?? '',

            $user->phone ?? '',

            $user->gender ?? '',

            $user->birth_place ?? '',

            $user->birth_date ? $user->birth_date->format('Y-m-d') : '',

            $user->address ?? '',

            $user->bio ?? '',

            $user->is_active ? '1' : '0',

            $user->approval_status ?? '',

            $user->created_at ? $user->created_at->format('Y-m-d H:i:s') : '',

            $user->updated_at ? $user->updated_at->format('Y-m-d H:i:s') : '',

        ];

    }



    /** Force Excel to treat value as text (prevents NIK scientific notation). */

    public static function excelText(?string $value): string

    {

        if ($value === null || $value === '') {

            return '';

        }



        return self::EXCEL_TEXT_PREFIX . (string) $value;

    }



    public static function excelRow(User $user): array

    {

        $row = self::row($user);

        $row[0] = self::excelText($user->nik ?? '');

        $row[3] = self::excelText($user->phone ?? '');



        return $row;

    }



    public static function minimalHeadings(): array

    {

        return ['NIK', 'Nama', 'Email'];

    }



    public static function minimalRow(?User $user): array

    {

        if (! $user) {

            return ['', '', ''];

        }



        return [

            self::excelText($user->nik ?? ''),

            $user->name ?? '',

            $user->email ?? '',

        ];

    }



    public static function displayHeadings(): array

    {

        return [

            __('lms.report.nik'),

            __('lms.report.name'),

            __('lms.report.email'),

            __('lms.report.phone'),

            __('lms.report.gender'),

            __('lms.report.birth_place'),

            __('lms.report.birth_date'),

            __('lms.report.address'),

            __('lms.report.bio'),

            __('lms.report.account_status'),

            __('lms.report.approval'),

            __('lms.report.registered_at'),

            __('lms.report.updated_at'),

        ];

    }



    public static function displayRow(User $user): array

    {

        return self::row($user);

    }



    public static function displayMinimalHeadings(): array

    {

        return [

            __('lms.report.nik'),

            __('lms.report.name'),

            __('lms.report.email'),

        ];

    }



    public static function displayMinimalRow(?User $user): array

    {

        if (! $user) {

            return ['-', '-', '-'];

        }



        return [

            $user->nik ?? '-',

            $user->name ?? '-',

            $user->email ?? '-',

        ];

    }

}

