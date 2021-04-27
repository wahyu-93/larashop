<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Category;
use Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = Category::paginate(10);

        $filterKeyword = $request->get('keyword');
        if ($filterKeyword){
            $categories = Category::where('name', 'LIKE', '%'.$filterKeyword.'%')->paginate(10);
        }

        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $new_categories = new Category;
        $new_categories->name = $request->get('name');
        $new_categories->slug = str_slug($request->get('name'), '-');

        if($request->file('image')){
            $file = $request->file('image')->store('categories', 'public');
            $new_categories->image = $file;
        };

        $new_categories->created_by = Auth::user()->id;
        $new_categories->save();

        return redirect()->route('categories.create')->with('status', 'Category successfully Create');
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
        $category = Category::findOrfail($id);
        return view('categories.edit', compact('category'));
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
        $category = Category::findOrfail($id);
        $category->name = $request->get('name');
        $category->slug = $request->get('slug');

        if($request->file('image')){
            if($category->image && file_exists(storage_path('app/public'.$category->image))){
                Storage::delete('public/'.$category->image);
            };

            $file = $request->file('image')->store('categories', 'public');
            $category->image = $file;
        };

        $category->updated_by = Auth::user()->id;
        $category->save();

        return redirect()->route('categories.edit',['id' => $category->id])->with('status', 'Category successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        if($category->image && file_exists(storage_path('app/public/'. $category->image)))(
            Storage::delete('public/'.$category->image)
        );

        $category->delete();
        return redirect()->route('categories.index')->with('status', 'Category successfully deleted');

    }
}
