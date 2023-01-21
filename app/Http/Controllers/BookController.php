<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // funkcja dla admina 
        $books = null; // Zakres widoczności poza ifem 
        if (auth()->user()->is_admin) {
            $books =  Book::with('user')->get();
        } else {
            $books =  Book::where('user_id', null)->get();
        }

        return Inertia::render('List', [ 
            'books' => $books
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Add');  // Utworzenie resources/js/add
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) // zapisywanie nowych książek
    {
        $data = $request->validate([ //tworzenie nowych książek
            "title" => ["required"],
            "author" => ["required"],
            "publisher" => ["required"],
            "description" => ["required"],
            "image" => ["required"],
            "release" => ["required"],
        ]);


        $book = new Book(); 

        $book->title = $data["title"];
        $book->author = $data["author"];
        $book->publisher = $data["publisher"];
        $book->description = $data["description"];
        $book->image = "data:image/png;base64," . base64_encode(file_get_contents($data["image"][0]->path()));
        $book->release = Carbon::parse($data["release"]);  
        // Carbon:;parse format odpowiedni dla bazy danych 

        $book->save(); // Mysql insert books

        return redirect()->intended('list')->with([  // powrót do listy z wiadomościa o dodaniu 
            'message' => "Książka dodana"
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        return Inertia::render('Item', [  // utworzenie do pages/Item/book <- id książki
            'book' => $book,
        ]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book) // usuwanie książki 
    {
        $book->delete();
        return redirect()->intended('list')->with([
            'message' => "Książka usunięta"
        ]);
    }


    /**
     * Rent a book
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function unrent(Book $book) // oddanie książki 
    {
        $book->user_id = null; 
        $book->save();
        return redirect()->intended('list')->with(  // przekierowanie do List 
           [ 'message' => "Książka oddana"]
        );
    }

    /**
     * Rent a book
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function rent(Book $book)
    {
        // sesja -> użyszkodnik 
        if (auth()->user()->books()->count() <= 5 && $book->user_id === null) {
            $book->user_id = auth()->user()->id;
            $book->save();
            return redirect()->intended('list'); // powrót do listy
        }
        return redirect()->intended('list')->withErrors([
            'message' => 'Oddaj książki! ',
        ]);
    }
}
