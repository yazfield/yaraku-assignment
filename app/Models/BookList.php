<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookList extends Model
{
    protected $fillable = ['name'];

    /*
     * Generates a slug when the name attribute is set.
     */
    public function setNameAttribute($value) {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = slugify($value, 
            config('config.slug.random_string_size', 12));
    }
    
    public function books()
    {
        return $this->belongsToMany(Book::class, 'list_books');
    }

    /*
     * Adds constraints to select a list's books conditioned by method inputs.
     */
    public function paginatedBooks(string $order = 'full_name', string $direction = 'asc', string $title = '', 
        string $fullName = ''): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        $query = $this->books()->with('author');
        if ($order === 'title') {
            $query = $query->orderBy('title', $direction);
        }
        $query = $query->join('authors', 'books.author_id', '=', 'authors.id');
        if ($order === 'full_name') {
            $query->orderBy('authors.first_name', $direction)
                ->orderBy('authors.last_name', $direction);
        }
        if ($fullName) {
            // The full name can contain both first and last name probably seperated
            // by space. We explode on space to make sure we can catch all authors
            // that has the query tokens either in first or last name.
            foreach (array_filter(explode(' ', $fullName), 'strlen') as $value) {
                $query->where(function ($query) use ($value){
                    $query->where('authors.first_name', 'like', "%$value%")
                        ->orWhere('authors.last_name', 'like', "%$value%");
                });
            }
        }
        if ($title) {
            $query->where('title', 'like', "%$title%");
        }
        return $query;
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
