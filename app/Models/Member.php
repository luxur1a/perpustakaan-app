<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi
    protected $fillable = [
        'member_no',
        'name',
        'date_of_birth',
    ];

    // Relasi ke tabel borrowing
    public function borrowings(){
        return $this->hasMany(Borrowing::class);
    }
    //
}
