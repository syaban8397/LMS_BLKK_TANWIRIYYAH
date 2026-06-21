<?php

namespace App\Http\Requests\Admin;

use App\Models\User;
use App\Support\UploadRules;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        /** @var User $user */
        $user = $this->route('user');

        return [
            'role' => ['required', Rule::in(['admin', 'instruktur', 'peserta'])],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique(User::class, 'email')->ignore($user->id)],
            'nik' => ['nullable', 'string', 'max:50'],
            'phone' => ['nullable', 'string', 'max:30'],
            'gender' => ['nullable', Rule::in(['L', 'P'])],
            'birth_place' => ['nullable', 'string', 'max:100'],
            'birth_date' => ['nullable', 'date'],
            'address' => ['nullable', 'string'],
            'bio' => ['nullable', 'string'],
            'photo' => UploadRules::profilePhoto(2048),
            'approval_status' => ['required', Rule::in(['pending', 'approved', 'rejected'])],
            'is_active' => ['nullable', 'boolean'],
            'password' => ['nullable', 'string', 'min:8'],
        ];
    }
}
