<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\Models\BookList as BookListModel;
use App\Models\Book as BookModel;

class BookListsPageTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testBookListsPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee(config('app.name'))
                    ->assertVisible('.card__book-list');
        });
    }
    
    public function testBookListsOpensModal()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->click('.card__book-list a[href="#addBookList"]')
                    ->waitFor('#addBookList')
                    ->assertSee(trans('book_lists.add_new'))
                    ->assertVisible('#book_list_name');
        });
    }

    public function testBookListsAddsList()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->click('.card__book-list a[href="#addBookList"]')
                    ->waitFor('#addBookList')
                    ->type('name', 'Test list')
                    ->click('button[type="submit"]')
                    ->waitForText('List page')
                    ->assertSee('Test list');
        });
    }

}
