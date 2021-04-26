<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(10);

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("users.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $new_user = new User;
        $new_user->name     = $request->get('name');
        $new_user->username = $request->get('username');
        $new_user->roles    = json_encode($request->get('roles'));
        $new_user->phone    = $request->get('phone');
        $new_user->address  = $request->get('address');
        $new_user->email    = $request->get('email');
        $new_user->password = Hash::make($request->get('password'));
        
        if($request->file('avatar')){
            $file = $request->file('avatar')->store('avatars', 'public');

            $new_user->avatar = $file;
        };

        $new_user->save();

        return redirect()->route('users.create')->with('status', 'user successfully created');
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
        $user = User::findOrfail($id);
        return view('users.edit', compact('user'));
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
        $user = User::findOrfail($id);

        $user->name     = $request->get('name');
        $user->roles    = json_encode($request->get('roles'));
        $user->address  = $request->get('address');
        $user->phone    = $request->get('phone');
        $user->status   = $request->get('status');

        if($request->file('avatar')){
            if($user->avatar && file_exists(storage_path('app/public/'. $user->avatar))){
                Storage::delete('public/'.$user->avatar);
            }
            $file = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $file;
        }

        $user->save();
        return redirect()->route('users.edit', ['id' => $user->id])->with('status', 'User successfully updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrfail($id);
        if($user->avatar && file_exists(storage_path('app/public/'. $user->avatar))){
            Storage::delete('public/'.$user->avatar);
        };

        $user->delete();
        return redirect()->route('users.index')->with('status', 'Users successfully deleted');
    }
}
