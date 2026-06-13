<?php

namespace App\Http\Controllers;

use App\Models\Certificate;

class CertificateVerifyController extends Controller
{
    public function show(string $number)
    {
        $certificate = Certificate::where('certificate_number', $number)
            ->with(['participant', 'class.program'])
            ->firstOrFail();

        return view('certificates.verify', compact('certificate'));
    }
}
