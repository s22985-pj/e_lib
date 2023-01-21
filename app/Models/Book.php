<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;



    /**
     * Get the user's books.
     */
    public function user() 
    {
        return $this->belongsTo(User::class); // relacja miiedzy tabelami ()
    }
}
