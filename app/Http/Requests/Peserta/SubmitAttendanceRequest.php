<?php

namespace App\Http\Requests\Peserta;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SubmitAttendanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => ['required', Rule::in(['present', 'permission', 'sick'])],
            'notes' => ['nullable', 'string', 'max:255'],
        ];
    }
}
