<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Process;

class ProcessTest extends TestCase
{
    use RefreshDatabase;


    public function setUp() : void
    {
        parent::setUp();
        $this->handleValidationExceptions();
    }

    public function testAddAndReadProcess()
    {
        $this->postJson(
            '/api/process', [
                'name' => 'NCT',
            ]
        )->assertStatus(201)
            ->assertJson(
                [
                    'message' => 'success',
                    'data' => [
                        'name' => 'NCT',
                    ]
                ]
            );

            
        $this->getJson('/api/process')
            ->assertStatus(200)
            ->assertJson(
                [
                    'data' => [
                        [
                            'name' => 'NCT'
                        ],
                    ]
                ]
            );


        $this->postJson('/api/process', [])
            ->assertStatus(422)
            ->assertJson(
                [
                    'message' => 'The given data was invalid.',
                    'errors' => [
                        'name' => [
                            'The name field is required.'
                        ]
                    ]
                ]
            );
    }


    public function testProcessSetFlow()
    {
        Process::factory()->count(3)->create();

        $this->putJson(
            '/api/process/1/flow', [
                'next' => [2],
            ]
        )->assertStatus(200)->assertJson(
            [
                'message' => 'success',
            ]
        );

        $this->putJson(
            '/api/process/2/flow', [
                'next' => [3],
            ]
        )->assertStatus(200)->assertJson(
            [
                'message' => 'success',
            ]
        );

        $this->getJson('/api/process')
            ->assertStatus(200)
            ->assertJson(
                [
                    'data' => [
                        [
                            'id' => 1,
                            'next' => [2],
                        ],
                        [
                            'id' => 2,
                            'next' => [3],
                        ],
                        [
                            'id' => 3,
                            'next' => [],
                        ],
                    ]
                ]
            );

        
        $this->putJson('/api/process/1/flow')
            ->assertStatus(422)
            ->assertJson(
                [
                    'message' => 'The given data was invalid.',
                    'errors' => [
                        'next' => [
                            'The next field is required.'
                        ]
                    ]
                ]
            );

        $this->putJson(
            '/api/process/1/flow', [
                'next' => 2,
            ]
        )->assertStatus(422)
            ->assertJson(
                [
                    'message' => 'The given data was invalid.',
                    'errors' => [
                        'next' => [
                            'The next must be an array.'
                        ]
                    ]
                ]
            );

        $this->putJson(
            '/api/process/1/flow', [
                'next' => [1]
            ]
        )->assertStatus(422)
            ->assertJson(
                [
                    'message' => 'The given data was invalid.',
                    'errors' => [
                        'next' => [
                            "can't set itself to next"
                        ]
                    ]
                ]
            );
    }
}
