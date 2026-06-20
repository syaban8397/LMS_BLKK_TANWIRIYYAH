<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Services\CertificateService;

class CertificateController extends Controller
{
    public function __construct(protected CertificateService $certificateService) {}

    public function index()
    {
        $certificates = Certificate::where('participant_id', auth()->id())
            ->with(['class.program'])
            ->latest('issued_at')
            ->paginate(10);

        return view('peserta.certificates.index', compact('certificates'));
    }

    public function download(Certificate $certificate)
    {
        if ($certificate->participant_id !== auth()->id()) {
            abort(403);
        }

        $path = $this->certificateService->downloadPath($certificate);

        if (!$path) {
            return redirect()
                ->route('peserta.certificates.index')
                ->with('error', __('lms.flash.certificate_file_not_found'));
        }

        return response()->download($path, $this->certificateService->downloadFilename($certificate));
    }
}
