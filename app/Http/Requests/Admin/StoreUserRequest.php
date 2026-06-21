<?php

namespace App\Http\Requests\Admin;

use App\Models\User;
use App\Support\UploadRules;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'role' => ['required', Rule::in(['admin', 'instruktur', 'peserta'])],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique(User::class, 'email')],
            'password' => ['required', 'string', 'min:8'],
            'nik' => ['nullable', 'string', 'max:30'],
            'phone' => ['nullable', 'string', 'max:20'],
            'gender' => ['nullable', Rule::in(['L', 'P'])],
            'birth_place' => ['nullable', 'string', 'max:100'],
            'birth_date' => ['nullable', 'date'],
            'address' => ['nullable', 'string'],
            'bio' => ['nullable', 'string'],
            'approval_status' => ['nullable', Rule::in(['pending', 'approved', 'rejected'])],
            'is_active' => ['nullable', 'boolean'],
            'photo' => UploadRules::profilePhoto(2048),
        ];
    }
}
