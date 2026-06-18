<?php

namespace Tests\Feature;

use Tests\TestCase;

class ErrorPageTest extends TestCase
{
    public function test_not_found_page_renders(): void
    {
        $response = $this->get('/halaman-tidak-ada-xyz');

        $response->assertNotFound();
        $response->assertSee(__('lms.errors_page.404_title'), false);
    }

    public function test_health_endpoint_is_available(): void
    {
        $response = $this->get('/up');

        $response->assertOk();
    }
}
