<?php

namespace App\Http\Requests\Peserta;

use App\Support\UploadRules;
use Illuminate\Foundation\Http\FormRequest;

class SubmissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'url' => ['nullable', 'url'],
            'file' => UploadRules::submissionFile(),
            'notes' => ['nullable', 'string'],
        ];
    }
}
