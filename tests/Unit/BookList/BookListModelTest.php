<?php

namespace Tests\Unit\BookList;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\BookList as BookListModel;

class BookListModelTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateBookList()
    {
        $bookList = BookListModel::create(['name' => 'My list']);
        $this->assertDatabaseHas('book_lists', [
            'name' => 'My list'
        ]);
    }

    public function testPaginatedBooksFindsExpectedResults()
    {
        $bookLists = factory(BookListModel::class, 3)->create()
        ->each(function ($bookList) {
            foreach (factory(\App\Models\Book::class, 2)->make() as $book) {
                $bookList->books()->save($book);
            }
        });

        $this->assertEquals(2, $bookLists[0]->paginatedBooks('full_name', 'asc')->count());
        $this->assertEquals(0, $bookLists[0]
            ->paginatedBooks('full_name', 'asc', 'somthing inexisting')->count());
        
        $book = $bookLists[0]->books->first();
        $this->assertEquals(1, $bookLists[0]
            ->paginatedBooks('full_name', 'asc', $book->title, $book->author->full_name)
            ->count());
    }

    public function testPaginatedBooksSortsCorrectly()
    {
        $bookLists = factory(BookListModel::class, 3)->create()
        ->each(function ($bookList) {
            foreach (factory(\App\Models\Book::class, 2)->make() as $book) {
                $bookList->books()->save($book);
            }
        });

        $books = $bookLists[0]->paginatedBooks('title', 'asc')->get();
        $this->assertTrue($books[0]->title <= $books[1]->title);

        $books = $bookLists[0]->paginatedBooks('title', 'desc')->get();
        $this->assertTrue($books[0]->title >= $books[1]->title);

        $books = $bookLists[0]->paginatedBooks('full_name', 'asc')->get();
        $this->assertTrue($books[0]->author->full_name <= $books[1]->author->full_name);

        $books = $bookLists[0]->paginatedBooks('full_name', 'desc')->get();
        $this->assertTrue($books[0]->author->full_name >= $books[1]->author->full_name);
    }
}
