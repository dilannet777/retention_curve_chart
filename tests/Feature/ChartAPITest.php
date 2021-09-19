<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_basic_test()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_show_onboard_chart()
    {
        $response = $this->get('/api/chart/onboard');

        $response->assertStatus(200);
    }
}
