<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanBook extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'loan_date',
        'return_date'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function rulesStore() {
        return [
            'user_id' => 'required|integer|min:1|max:1',
            'book_id' => 'required|integer|min:1|max:1',
            'loan_date' => 'required|date'
        ];
    }

    public function rulesUpdate() {
        return [
            'return_date' => 'required|date'
        ];
    }
}
