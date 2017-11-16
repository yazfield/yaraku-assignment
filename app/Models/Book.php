<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['title', 'author_id'];

    /*
     * Generates a slug when the name attribute is set.
     */
    public function setTitleAttribute($value) {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = slugify($value);
    }
    
    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function lists()
    {
        return $this->belongsToMany(BookList::class, 'list_books');
    }

    /*
     * Constrait books that are not in a given list.
     */
    public function scopeNotInList($query, string $bookListSlug)
    {
        return $query->has('lists', '=', 0, 'and', function ($query) use ($bookListSlug){
            $query->where('slug', $bookListSlug);
        });
    }
}
