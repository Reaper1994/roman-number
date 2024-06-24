<?php

namespace Tests\Feature;

use App\Services\RomanNumeralConverter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Contracts\ConversionRepositoryInterface;
use App\Models\Conversion;
use Tests\TestCase;

class ConversionFeatureTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_convert_and_store_an_integer()
    {
        // Mock the RomanNumeralConverter service
        $serviceMock = \Mockery::mock(RomanNumeralConverter::class);
        $serviceMock->shouldReceive('convertInteger')->andReturn('LXVII');

        // Bind the mock to the service container
        $this->app->instance(RomanNumeralConverter::class, $serviceMock);

        // Perform a POST request to convert the integer 67
        $response = $this->json('POST', '/api/v1/convert', ['integer' => 67]);

        // Assert the response status
        $response->assertStatus(201);

        // Assert the response structure and specific values
        $response->assertJsonStructure([
            'data' => [
                'integer_value',
                'roman_numeral',
                'created_at',
                'updated_at'
            ]
        ]);

        $response->assertJsonFragment([
            'integer_value' => 67,
            'roman_numeral' => 'LXVII'
        ]);
    }

    /** @test */
    public function it_can_list_recent_conversions()
    {
        $response = $this->json('GET', '/api/v1/recent-conversions');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'integer_value',
                    'roman_numeral',
                    'created_at',
                    'updated_at'
                ]
            ],
            'links' => [
                'self',
                'first',
                'last',
                'prev',
                'next'
            ],
            'meta' => [
                'current_page',
                'from',
                'last_page',
                'links' => [
                    '*' => [
                        'url',
                        'label',
                        'active'
                    ]
                ],
                'path',
                'per_page',
                'to',
                'total'
            ]
        ]);;
    }

    /** @test */
    public function it_can_list_top_conversions()
    {
        // Optionally, prepare data in the database or mock the repository to return specific data

        $response = $this->json('GET', '/api/v1/top-conversions');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'integer_value',
                    'count',
                ]
            ]
        ]);
    }



}
