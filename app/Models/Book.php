<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use Kirschbaum\PowerJoins\PowerJoins;

class Book extends Model
{
    use HasFactory,PowerJoins;

    protected $fillable=[
        'name'
    ];

    public function categories(){
        return $this->belongsToMany(Category::class,'book_category');
    }
    public function authors(){
        return $this->belongsToMany(Author::class,'author_book');
    }
}
