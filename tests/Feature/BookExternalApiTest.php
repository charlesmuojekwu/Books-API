<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookExternalApiTest extends TestCase
{
    /**
     *
     *
     * @test
     */
    public function a_book_can_be_requested_from_api_by_name()
    {

        $response = $this->getJson('/api/external-books?name=A Game of Thrones');

        $response
            ->assertStatus(200)
            ->assertJson([
                'status_code' => '200',
                'data' =>[[
                    'name' => 'A Game of Thrones'
                ]]
            ]);
    }
}
