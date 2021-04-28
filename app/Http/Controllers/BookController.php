<?php

namespace App\Http\Controllers;

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
        //
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
        //
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
        //
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
