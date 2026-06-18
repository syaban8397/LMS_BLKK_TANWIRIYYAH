<?php

namespace App\Http\Controllers;

use App\Models\Certificate;

class CertificateVerifyController extends Controller
{
    public function show(string $number)
    {
        $certificate = Certificate::where('certificate_number', $number)
            ->with(['participant', 'class.program'])
            ->first();

        if (! $certificate) {
            return view('certificates.verify-invalid', compact('number'));
        }

        return view('certificates.verify', compact('certificate'));
    }
}
