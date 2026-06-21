<?php

namespace App\Http\Requests\Instruktur;

use App\Models\Material;
use Illuminate\Foundation\Http\FormRequest;

class MaterialRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return Material::validationRules();
    }
}
