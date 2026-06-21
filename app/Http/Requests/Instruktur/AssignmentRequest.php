<?php

namespace App\Http\Requests\Instruktur;

use App\Models\Assignment;
use Illuminate\Foundation\Http\FormRequest;

class AssignmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return Assignment::validationRules();
    }
}
