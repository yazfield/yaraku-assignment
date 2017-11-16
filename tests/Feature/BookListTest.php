<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\BookList as BookListModel;
use App\Models\Book as BookModel;

class BookListTest extends TestCase
{
    use RefreshDatabase;

    public function testPageNotFound()
    {
        $response = $this->get('somemissingpage');
        $response->assertStatus(404);
        $response->assertSee(trans('global.errors.404'));
        $response->assertSee(trans('global.back_home'));

        $response = $this->get(route('book_list', ['slug' => 'someslug']));
        $response->assertStatus(404);
        $response->assertSee(trans('global.errors.404'));
        $response->assertSee(trans('global.back_home'));
    }

    public function testBookListsIndexPage()
    {
        $bookLists = factory(BookListModel::class, 3)->create()
        ->each(function ($bookList) {
            foreach (factory(BookModel::class, 1)->make() as $book) {
                $bookList->books()->save($book);
            }
        });

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('href="#addBookList"');
        $response->assertSee('id="book_list_name"');
        foreach ($bookLists as $bookList) {
            // We truncate the title because of the ellipsis css rule.
            $response->assertSee(explode(' ', $bookList->title)[0]);
        } 
    }

    public function testSingleBookListsPage()
    {
        $bookLists = factory(BookListModel::class, 3)->create()
        ->each(function ($bookList) {
            foreach (factory(BookModel::class, 1)->make() as $book) {
                $bookList->books()->save($book);
            }
        });

        $bookList = $bookLists[0];

        $response = $this->get(route('book_list', ['slug' => $bookList->slug]));
        $response->assertStatus(200);
        $response->assertSee($bookList->name);
        $response->assertSee($bookList->books->first()->title);
        $response->assertSee($bookList->books->first()->author->full_name);
        $response->assertSee('id="search_title"');
        $response->assertSee('id="search_full_name"');
    }

    public function testSingleBookListsPageSearch()
    {
        $bookLists = factory(BookListModel::class, 3)->create()
        ->each(function ($bookList) {
            foreach (factory(BookModel::class, 1)->make() as $book) {
                $bookList->books()->save($book);
            }
        });

        
        $bookList = $bookLists[0];
        $book = $bookList->books->first();
        $url = url(route('book_list', ['slug' => $bookList->slug]), 
            ['title' => $book->title]);

        $response = $this->get($url);
        $response->assertStatus(200);
        $response->assertSee($bookList->name);
        $response->assertSee($book->title);
        $response->assertSee($book->author->full_name);

        $url = url(route('book_list', ['slug' => $bookList->slug]), 
            ['full_name' => $book->author->full_name]);

        $response = $this->get($url);
        $response->assertStatus(200);
        $response->assertSee($bookList->name);
        $response->assertSee($book->title);
        $response->assertSee($book->author->full_name);
    }

    public function testCreateBookListSuccess()
    {
        $response = $this->post(route('add_book_list', [
            'name' => 'Some name'
        ]));

        $this->assertDatabaseHas('book_lists', [
            'name' => 'Some name'
        ]);
        $response->assertRedirect();
        $response->assertSessionHas('success');
    }

    public function testCreateBookListValidationError()
    {
        $response = $this->post(route('add_book_list', [
            'name' => ''
        ]));

        $this->assertDatabaseMissing('book_lists', [
            'name' => 'Some name'
        ]);
        $response->assertRedirect();
        $response->assertSessionHas('errors');

        $response = $this->post(route('add_book_list', [
            'name' => str_random(55)
        ]));

        $this->assertDatabaseMissing('book_lists', [
            'name' => 'Some name'
        ]);
        $response->assertRedirect();
        $response->assertSessionHas('errors');
    }

    public function testAttachBookToListSuccess()
    {
        $bookLists = factory(BookListModel::class, 3)->create()
        ->each(function ($bookList) {
            foreach (factory(BookModel::class, 1)->make() as $book) {
                $bookList->books()->save($book);
            }
        });

        $bookList = $bookLists[0];
        $book = $bookLists[1]->books->first();
        $this->assertDatabaseMissing('list_books', [
            'book_id' => $book->id,
            'book_list_id' => $bookList->id,
        ]);

        $url = route('attach_book', ['slug' => $bookList->slug]);
        $response = $this->post($url, [
            'book_slug' => $book->slug,
        ]);

        $this->assertDatabaseHas('list_books', [
            'book_id' => $book->id,
            'book_list_id' => $bookList->id,
        ]);
        $response->assertRedirect();
        $response->assertSessionHas('success');
    }

    public function testAttachBookToListFail()
    {
        $bookLists = factory(BookListModel::class, 3)->create()
        ->each(function ($bookList) {
            foreach (factory(BookModel::class, 1)->make() as $book) {
                $bookList->books()->save($book);
            }
        });

        $bookList = $bookLists[0];
        $book = $bookLists[1]->books->first();

        $url = route('attach_book', ['slug' => $bookList->slug]);
        $response = $this->post($url, [
            'book_slug' => 'someslug',
        ]);
        $response->assertRedirect();
        $response->assertSessionHas('error');

        $url = route('attach_book', ['slug' => 'someslug']);
        $response = $this->post($url, [
            'book_slug' => 'someslug',
        ]);
        $response->assertStatus(404);
    }

    public function testdetachBookToListSuccess()
    {
        $bookLists = factory(BookListModel::class, 3)->create()
        ->each(function ($bookList) {
            foreach (factory(BookModel::class, 1)->make() as $book) {
                $bookList->books()->save($book);
            }
        });

        $bookList = $bookLists[0];
        $book = $bookLists[0]->books->first();

        $this->assertDatabaseHas('list_books', [
            'book_id' => $book->id,
            'book_list_id' => $bookList->id,
        ]);

        $url = route('detach_book', ['slug' => $bookList->slug]);
        $response = $this->delete($url, [
            'id' => $book->slug,
        ]);
        
        $this->assertDatabaseMissing('list_books', [
            'book_id' => $book->id,
            'book_list_id' => $bookList->id,
        ]);
        $response->assertRedirect();
        $response->assertSessionHas('success');
    }

    public function testdetachBookToListFail()
    {
        $bookLists = factory(BookListModel::class, 3)->create()
        ->each(function ($bookList) {
            foreach (factory(BookModel::class, 1)->make() as $book) {
                $bookList->books()->save($book);
            }
        });

        $bookList = $bookLists[0];
        $book = $bookLists[1]->books->first();

        $url = route('detach_book', ['slug' => $bookList->slug]);
        $response = $this->delete($url, [
            'id' => 'someslug',
        ]);
        $response->assertRedirect();
        $response->assertSessionHas('error');

        $url = route('attach_book', ['slug' => 'someslug']);
        $response = $this->delete($url, [
            'id' => 'someslug',
        ]);
        $response->assertSessionHas('error');
    }
}
    