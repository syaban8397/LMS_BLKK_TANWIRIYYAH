<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Http\Request;

trait ValidatesAnnouncement
{
    protected function validatedAnnouncement(Request $request): array
    {
        return $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
        ]);
    }
}
