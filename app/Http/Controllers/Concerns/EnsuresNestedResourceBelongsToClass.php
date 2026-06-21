<?php

namespace App\Http\Controllers\Concerns;

use App\Models\ClassModel;

trait EnsuresNestedResourceBelongsToClass
{
    protected function ensureBelongsToClass(object $model, ClassModel $class, string $attribute = 'class_id'): void
    {
        if ($model->{$attribute} !== $class->id) {
            abort(404);
        }
    }
}
