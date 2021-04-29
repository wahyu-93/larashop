<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Book;
use Auth;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // with('categories') itu meurujuk pada function relasi di model book
        $books = Book::with('categories')->paginate(10);
        return view('books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('books.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $book = new Book;

        $book->title        = $request->get('title');
        $book->description  = $request->get('description');
        $book->author       = $request->get('author');
        $book->publisher    = $request->get('publisher');
        $book->price        = $request->get('price');
        $book->stock        = $request->get('stock');
        $book->status       = $request->get('save_action');

        $cover = $request->file('cover');
        if($cover){
            $file = $cover->store('book-covers', 'public');
            $book->cover = $file;
        }

        $book->slug         = str_slug($request->get('title'), '-');
        $book->created_by   = Auth::user()->id;
        $book->save();

        $book->categories()->attach($request->get('categories'));

        if($request->get('save_action')=="PUBLISH"){
            return redirect()->route('books.create')->with('status', 'Book successfully saved and publisher');
        }
        else{
            return redirect()->route('books.create')->with('status', 'Book saved as draft');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $book = Book::findOrfail($id);
        return view('books.edit', compact('book'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $book = Book::findOrfail($id);

        $book->title        = $request->get('title');
        $book->slug         = $request->get('slug' );
        $book->description  = $request->get('description');
        $book->author       = $request->get('author');
        $book->publisher    = $request->get('publisher');
        $book->price        = $request->get('price');
        $book->stock        = $request->get('stock');
        $book->status       = $request->get('status');

        $cover = $request->file('cover');
        if($cover){
            if($book->cover && file_exists(storage_path('app/public'.$book->cover))){
                Storage::delete('public/'.$book->cover);
            };            

            $file = $cover->store('book-covers', 'public');
            $book->cover = $file;
        }

        $book->updated_by   = Auth::user()->id;
        $book->save();

        $book->categories()->sync($request->get('categories'));

        return redirect()->route('books.edit', ['id' => $book->id])->with('status', 'Book Successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
