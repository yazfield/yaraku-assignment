<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\BookList as BookListModel;
use App\Models\Book as BookModel;
use App\Models\Author as AuthorModel;

class AuthorApiTest extends TestCase
{
    use RefreshDatabase;
    
    public function testNoDataResponse()
    {
        $response = $this->get('/api/authors');

        $response->assertStatus(200);
        $response->assertJsonStructure();
        $response->assertJsonCount(0);
    }

    public function testJsonResponse()
    {
        $bookLists = factory(BookListModel::class, 3)->create()
        ->each(function ($bookList) {
            foreach (factory(BookModel::class, 1)->make() as $book) {
                $bookList->books()->save($book);
            }
        });

        $authors = AuthorModel::orderBy('last_name', 'asc')->orderBy('first_name', 'asc')
            ->select('last_name', 'first_name', 'id')->get()->toArray();

        $response = $this->get('/api/authors');
        
        $response->assertStatus(200);
        $response->assertJson($authors);
        $response->assertJsonCount(3);
    }
}
