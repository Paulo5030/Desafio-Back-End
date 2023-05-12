<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Fig\Http\Message\StatusCodeInterface;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function testReturnSuccessResponse(): void
    {
        $response = $this->get('/');

        $response->assertStatus(StatusCodeInterface::STATUS_OK);
    }
}
