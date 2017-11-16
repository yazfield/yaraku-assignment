<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Book extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'title' => $this->title,
            'author_id' => $this->author_id,
            'author_first_name' => $this->author->first_name,
            'author_last_name' => $this->author->last_name,
        ];
    }
}
