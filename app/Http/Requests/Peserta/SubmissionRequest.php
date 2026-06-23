<?php

namespace App\Http\Requests\Peserta;

use App\Models\Assignment;
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
        /** @var Assignment|null $assignment */
        $assignment = $this->route('assignment');
        $type = $assignment?->submission_type ?? 'file_and_link';

        $rules = [
            'notes' => ['nullable', 'string'],
        ];

        if ($type === 'file') {
            $rules['file'] = str_replace('nullable|', 'required|', UploadRules::submissionFile());
            $rules['url'] = ['prohibited'];
        } elseif ($type === 'link') {
            $rules['url'] = ['required', 'url'];
            $rules['file'] = ['prohibited'];
        } else {
            $rules['file'] = 'nullable|file|mimes:' . UploadRules::SUBMISSION_MIMES . '|max:20480|required_without:url';
            $rules['url'] = ['nullable', 'url', 'required_without:file'];
        }

        return $rules;
    }
}
