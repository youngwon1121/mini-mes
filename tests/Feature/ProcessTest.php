<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProcessTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAddProcess()
    {
        $response = $this->post('/api/process', [
            'name' => 'NCT',
        ]);
        $response
            ->assertStatus(200)
            ->assertJson([
                'result' => 'SUCCESS',
                'data' => [
                    'name' => 'NCT',    
                ]
            ]);

        $response = $this->postJson('/api/process', []);
        $response
            ->assertStatus(422)
            ->assertJson([
                'result' => 'FAIL',
                'message' => 'name is required.'
            ]);
    }
}
