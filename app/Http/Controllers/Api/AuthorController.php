<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Http\Resources\Author as AuthorResource;

class AuthorController extends Controller
{
    public function index()
    {
        $fullName = request('full_name', '');

        $query = Author::ofFullName($fullName)
            ->limit(request('limit', 5))
            ->orderBy('last_name', 'asc')
            ->orderBy('first_name', 'asc');

        AuthorResource::withoutWrapping();
        return AuthorResource::collection($query->get());
    }
}
