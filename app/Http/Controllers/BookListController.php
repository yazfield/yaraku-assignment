<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Book, BookList, Author};

/*
 * 
 */
class BookListController extends Controller
{
    /*
     * Index page on Book lists.
     */
    public function index()
    {
        // Paginate 8 items only to allow the 9th item to be a button
        // that opens a modal for adding a new list. 
        $bookLists = BookList::paginate(8);
        $breadcrumb = $this->getBreadcrumbFor([['name' => 'home']]);

        return view('booklist.index', compact('bookLists', 'breadcrumb'));
    }

    public function show(BookList $bookList)
    {
        $breadcrumb = $this->getBreadcrumbFor([
            ['name' => 'home'],
            ['name' => 'book_list', 'params' => ['slug' => $bookList->slug]],
        ]);

        $order = strtolower(request('order', 'title'));
        $direction = strtolower(request('direction', 'asc'));
        $title = strtolower(request('title'));
        $ful_name = strtolower(request('full_name'));

        $paginatedBooks = $bookList->paginatedBooks($order, $direction, $title, $ful_name)
            ->paginate(config('config.book_lists.per_page', 3))
            ->appends(compact('order', 'direction', 'title','full_name'));

        return view('booklist.show', compact('bookList', 'paginatedBooks', 'breadcrumb'));
    }

    public function store()
    {
        $bookList = request()->validate([
            'name' => 'required|min:1|max:50',
        ]);

        $bookList = BookList::create($bookList);

        if ($bookList) {
            return redirect()->route('book_list', ['slug' => $bookList->slug])
                ->with('success', 'Book list created');
        }
        return back()->with('error', 'Book list was not created');
    }

    /*
     * Detaches a book from a list.
     */
    public function detachBook(BookList $bookList)
    {
        $book = Book::where('slug', request('id'))->first();
        if (!$book) {
            return back()->with('error', 'The book was not found');
        }
        
        if ($bookList->books()->detach($book->id)) {
            return back()->with('success', 'The book was detached');
        }

        return back()->with('error', 'The book could not be detached');
    }

    /*
     * Attaches a book to a list.
     */
    public function attachBook(BookList $bookList)
    {
        $book = Book::where('slug', request('book_slug'))->first();
        if (!$book) {
            return back()->with('error', 'The book was not found');
        }
        
        if ($bookList->books()->save($book)) {
            return back()->with('success', 'The book was attached');
        }

        return back()->with('error', 'The book could not be attached');
    }

    /*
     * Creates a book and possibly author then attaches it to a list.
     */
    public function attachNonexistingBook(BookList $bookList)
    {
        $validator = $this->validateNonexistingBook();
        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        try {
            return \DB::transaction(function () use ($bookList) {
                $inputs = request()->all();
                $author = $this->findOrCreateAuthor(array_only($inputs,
                    ['author_id', 'last_name', 'first_name']));
                $book = Book::create(['title' => $inputs['title'], 'author_id' => $author->id]);

                if ($bookList->books()->save($book)) {
                    return back()->with('success', 'The book was attached');
                }
            });
        } catch (\Exception $e) {
            return back()->with('error', 'The book could not be attached');
        }
    }

    private function findOrCreateAuthor(array $inputs)
    {
        if ($inputs['author_id']) {
            return Author::find($inputs['author_id']);
        }
        return Author::create(array_only($inputs, ['last_name', 'first_name']));
    }

    private function validateNonexistingBook()
    {
        $validator = validator(request()->all(),[
            'title' => 'required|unique:books|min:1|max:50',
            'author_id', 'sometimes|exists:authors,id'
        ]);
        $validator->sometimes('last_name', 'min:1|max:50', function($data){
            return !$data->author_id;
        });
        $validator->sometimes('first_name', 'min:1|max:50', function($data){
            return !$data->author_id;
        });
        return $validator;
    }
}
