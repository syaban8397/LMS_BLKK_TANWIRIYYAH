<?php

namespace App\Support;

class UploadRules
{
    public const DOCUMENT_MIMES = 'pdf,doc,docx,ppt,pptx,zip,rar,jpg,jpeg,png';

    public const SUBMISSION_MIMES = 'pdf,doc,docx,ppt,pptx,zip,rar,jpg,jpeg,png,txt,xlsx,xls';

    public const IMAGE_MIMES = 'jpg,jpeg,png,webp';

    public static function documentAttachment(int $maxKb = 102400): string
    {
        return 'nullable|file|mimes:' . self::DOCUMENT_MIMES . '|max:' . $maxKb;
    }

    public static function submissionFile(int $maxKb = 20480): string
    {
        return 'nullable|file|mimes:' . self::SUBMISSION_MIMES . '|max:' . $maxKb;
    }

    public static function profilePhoto(int $maxKb = 5120): string
    {
        return 'nullable|image|mimes:' . self::IMAGE_MIMES . '|max:' . $maxKb;
    }
}
