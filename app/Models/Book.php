<?php

namespace App\Models;
use App\Models\Author;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BookAuthor;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'publication_year'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function authors()
    {
        return $this->belongsToMany(Author::class, 'book_authors')->using(BookAuthor::class);
    }

    public function rulesStore() {
        return [
            'title'          => 'required',
            'publication_year' => 'required|min:4',
            'author_id' => 'required|min:1',
        ];
    }

    public function rulesUpdate() {
        return [
            'title'          => 'sometimes|min:1',
            'publication_year' => 'sometimes|min:4',
            'author_id' => 'sometimes|min:1',
        ];
    }
}
