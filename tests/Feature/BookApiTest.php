<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\BookList as BookListModel;
use App\Models\Book as BookModel;

class BookApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test if the page returns json.
     *
     * @return void
     */
    public function testNoDataResponse()
    {
        $response = $this->get('/api/books');

        $response->assertStatus(200);
        $response->assertJsonStructure();
        $response->assertJsonCount(0);
    }

    /**
     * Test the returned json.
     *
     * @return void
     */
    public function testJsonResponse()
    {
        $bookLists = factory(BookListModel::class, 3)->create()
        ->each(function ($bookList) {
            foreach (factory(BookModel::class, 1)->make() as $book) {
                $bookList->books()->save($book);
            }
        });

        $books = BookModel::orderBy('title', 'asc')
            ->select('title', 'slug', 'id')->get()->toArray();

        $response = $this->get('/api/books');
        
        $response->assertStatus(200);
        $response->assertJson($books);
        $response->assertJsonCount(3);
    }
}
