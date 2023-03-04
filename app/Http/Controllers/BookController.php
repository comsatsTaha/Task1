<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $book =Book::with('categories')->get();
        dd($book);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $book= Book::create($request->all());
        $book->categories()->attach(['1','2']);

    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        //
    }

    public function mystery(){
        $books = Book::wherehas('categories', function ($query) {
            $query->where('category_name', 'Mystery');
        })
        ->with('authors')
        ->orderBy('name')
        ->select('name', 'books.created_at')
        ->get();

        echo $books;
    }

    public function johnsmith(){
        $books = Book::whereHas('authors', function ($query) {
            $query->where(['first_name'=> 'John','last_name'=> 'Smith']);
        })
        ->with('categories')
        ->orderBy('created_at', 'desc')
        ->get(['name', 'created_at']);
        
        echo $books;
    }

    public function thriller(){
        $authors = Author::whereHas('books.categories', function ($query) {
            $query->where('category_name', 'Thriller');
        })
        ->withCount(['books' => function ($query) {
            $query->whereHas('categories', function ($query) {
                $query->where('category_name', 'Thriller');
            });
        }])
        ->orderBy('last_name', 'asc')
        ->get();
        
        dd($authors);
    }

    public function janedoe(){


        $categories = Category::whereHas('books', function ($query) {
            $query->whereHas('authors', function ($query) {
                $query->where('first_name', 'Jane')->where('last_name', 'Doe');
            });
        })->withCount(['books' => function ($query) {
            $query->whereHas('authors', function ($query) {
                $query->where('first_name', 'Jane')->where('last_name', 'Doe');
            });
        }])->orderBy('category_name')->get(['category_name', 'books_count']);

        echo $categories;
    }
}
