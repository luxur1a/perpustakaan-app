<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi
    protected $fillable = [
        'member_id',
        'book_id',
        'borrow_date',
        'return_date',
    ];

    public function member(){
        return $this->belongsTo(Member::class);
    }

    public function book(){
        return $this->belongsTo(Book::class);
    }
    //
}
