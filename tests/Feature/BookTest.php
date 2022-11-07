<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    private $response;

    protected function setUp(): void
    {
        parent::setUp();

        $this->response = $this->postJson('/api/v1/books/', $this->data());
    }


    /**
     * A basic feature test example.
     *
     * @test
     */
    public function a_book_can_be_created()
    {

        $this->assertCount(1, Book::all());
        $this->response
            ->assertStatus(201)
            ->assertJson([
                'status_code' => '201',
                'data' =>['book' => [
                    'name' => 'A Game of Thrones'
                ]]
            ]);

    }


    /** @test */
    public function a_book_can_be_updated()
    {


        $response = $this->patchJson('/api/v1/books/'.Book::first()->id,[
            'name' => 'A Game of Thrones updated',
        ] );

        $response
            ->assertStatus(201)
            ->assertJson([
                'status_code' => '201',
                'data' =>[
                    'name' => 'A Game of Thrones updated'
                ]
            ]);

        $this->assertEquals('A Game of Thrones updated', Book::first()->name);


    }



    /** @test */
    public function a_book_can_be_deleted()
    {

        $this->assertCount(1, Book::all());


        $response = $this->deleteJson('/api/v1/books/'. Book::first()->id);

        $response
            ->assertStatus(200)
            ->assertJson([
                'status_code' => '204',
                'data' =>[]
            ]);

        $this->assertCount(0, Book::all());
    }


    /** @test */
    public function can_get_all_available_books()
    {

        $response = $this->getJson('/api/v1/books/');

        $response
            ->assertStatus(200)
            ->assertJson([
                'status_code' => '200',
            ]);

        $this->assertCount(1, Book::all());
    }


    /** @test */
    public function a_book_can_be_fetched_by_id()
    {

        $response = $this->getJson('/api/v1/books/'.Book::first()->id);

        $response
            ->assertStatus(200)
            ->assertJson([
                'status_code' => '200',
                'data' =>[
                    'id' => 1
                ]
            ]);


            $this->assertEquals(1, Book::first()->id);
    }


    private function data():array
    {
        return [
            "name" => "A Game of Thrones",
            "isbn" => "978-0553103540",
            "authors" => "George R. R. Martin",
            "number_of_pages" =>  694,
            "publisher" => "Bantam Books",
            "country" =>  "United States",
            "release_date" => "1996-08-01"
        ];
    }
}
