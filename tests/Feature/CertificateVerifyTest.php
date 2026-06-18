<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\CreatesTrainingContext;
use Tests\TestCase;

class CertificateVerifyTest extends TestCase
{
    use CreatesTrainingContext;
    use RefreshDatabase;

    public function test_valid_certificate_number_shows_verification_page(): void
    {
        $context = $this->createTrainingContext();
        $certificate = $this->createCertificate($context, 'DM-VERIFY-0001');

        $response = $this->get(route('certificates.verify', $certificate->certificate_number));

        $response->assertOk();
        $response->assertSee($certificate->certificate_number);
        $response->assertSee($context['participant']->name);
    }

    public function test_invalid_certificate_number_shows_invalid_page(): void
    {
        $response = $this->get(route('certificates.verify', 'INVALID-NUMBER-9999'));

        $response->assertOk();
        $response->assertSee('INVALID-NUMBER-9999');
    }
}
