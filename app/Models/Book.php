<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi
    protected $fillable = [
        'title',
        'publisher',
        'dimension',
        'stock',
    ];

    // Relasi ke tabel borrowing
    public function borrowings(){
        return $this->hasMany(Borrowing::class);
    }
    //
}
