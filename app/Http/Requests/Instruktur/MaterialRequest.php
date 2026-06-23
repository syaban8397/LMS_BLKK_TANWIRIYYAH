<?php

namespace App\Http\Requests\Instruktur;

use App\Models\Material;
use App\Support\UploadRules;
use Illuminate\Foundation\Http\FormRequest;

class MaterialRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation(): void
    {
        if (! $this->has('content_mode')) {
            $hasFile = $this->hasFile('file');
            $hasYoutube = filled($this->input('youtube_url'));

            $mode = 'both';
            if ($hasFile && ! $hasYoutube) {
                $mode = 'file';
            } elseif ($hasYoutube && ! $hasFile) {
                $mode = 'link';
            }

            $this->merge(['content_mode' => $mode]);
        }
    }

    public function rules(): array
    {
        $rules = Material::validationRules();
        $rules['content_mode'] = 'required|in:file,link,both';

        $mode = $this->input('content_mode', 'both');

        if ($mode === 'file' || $mode === 'both') {
            $requireFile = $this->isMethod('post') && in_array($mode, ['file', 'both'], true);
            $rules['file'] = ($requireFile ? 'required|' : 'nullable|') . 'file|mimes:' . \App\Support\UploadRules::DOCUMENT_MIMES . '|max:102400';
        } else {
            $rules['file'] = 'nullable';
        }

        if ($mode === 'link' || $mode === 'both') {
            $rules['youtube_url'] = 'required|url|max:255';
        } else {
            $rules['youtube_url'] = 'nullable';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'youtube_url.required' => __('lms.flash.material_need_content'),
            'file.required' => __('lms.flash.material_need_content'),
        ];
    }
}
