<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BookAuthor;



class Author extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'date_of_birth'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function books() {
        return $this->belongsToMany(Author::class, 'book_authors')->using(BookAuthor::class);
    }

    public function rules() {
        return [
            'name'          => 'required',
            'date_of_birth' => 'required|date',
        ];
    }
}
