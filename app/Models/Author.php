<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $fillable = ['last_name', 'first_name'];
    protected $appends = ['full_name'];

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
    
    public function books()
    {
        return $this->hasMany(Book::class);
    }

    public function scopeOfFullName($query, string $fullName)
    {
        // TODO: refactor this
        foreach (array_filter(explode(' ', $fullName), 'strlen') as $value) {
            $query->where(function ($query) use ($value){
                $query->where('authors.first_name', 'like', "%$value%")
                    ->orWhere('authors.last_name', 'like', "%$value%");
            });
        }
        return $query;
    }
}
