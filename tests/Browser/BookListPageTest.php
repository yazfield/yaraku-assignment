<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\Models\BookList as BookListModel;
use App\Models\Book as BookModel;

class BookListPageTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testBookListPage()
    {
        $bookLists = factory(BookListModel::class, 3)->create()
        ->each(function ($bookList) {
            foreach (factory(BookModel::class, 1)->make() as $book) {
                $bookList->books()->save($book);
            }
        });
        $bookList = $bookLists[0];
        $book = $bookList->books()->first();
        $this->browse(function (Browser $browser) use ($bookList, $book){
            $browser->visit(route('book_list', ['slug' => $bookList->slug]))
                ->assertSee($bookList->name)
                ->assertSee($book->title)
                ->assertSee($book->author->full_name);
        });
    }
    
    public function testBookListPageSearch()
    {
        $bookLists = factory(BookListModel::class, 3)->create()
        ->each(function ($bookList) {
            foreach (factory(BookModel::class, 2)->make() as $book) {
                $bookList->books()->save($book);
            }
        });
        $bookList = $bookLists[0];
        $this->browse(function (Browser $browser) use ($bookList){
            $book = $bookList->books[0];
            $book1 = $bookList->books[1];
            $browser->visit(route('book_list', ['slug' => $bookList->slug]))
                ->assertSee($book->title)
                ->assertSee($book1->title)
                ->type('title', $book->title)
                ->press('Search')
                ->waitForText($bookList->name)
                ->assertSee($book->title)
                ->assertDontSee($book1->title);
        });
    }
}
