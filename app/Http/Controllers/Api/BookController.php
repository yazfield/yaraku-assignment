<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Routing\Controller;
use App\Http\Resources\Book as BookResource;

class BookController extends Controller
{
    public function index()
    {
        $title = request('title', '');
        $bookListSlug = request('book_list_slug', '');

        $query = Book::with('author')
            ->limit(request('limit', 5))
            ->orderBy('title', 'asc');

        if ($bookListSlug) {
            $query->notInList($bookListSlug);
        }
        if ($title) {
            $query->where('title', 'like', "%{$title}%");
        }

        BookResource::withoutWrapping();
        return BookResource::collection($query->get());
    }
}
