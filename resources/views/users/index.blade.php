@extends('layouts.global')

@section('title')
    Users List
@endsection

@section('content')
    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th><b>Name</b></th>
                <th><b>Username</b></th>
                <th><b>Email</b></th>
                <th><b>Avatar</b></th>
                <th><b>Action</b></th>
            </tr>
        </thead>

        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->avatar)
                            <img 
                                src="{{ asset('storage/'.$user->avatar) }}"
                                width="70px"/> 
                        @else
                            N/A
                        @endif
                    </td>
                    <td>
                        <a 
                            class="btn-info text-white btn-sm"
                            href="{{ route('users.edit', ['id' => $user->id]) }}">
                            Edit
                        </a>
                        &nbsp;
                        <form
                            onsubmit="return confirm('Delete this user permanently ?')"
                            class="d-inline"
                            action="{{ route('users.destroy', ['id' => $user->id]) }}"
                            method="POST">
                            @csrf
                            @method('DELETE')

                            <input type="submit" value="delete" class="bnt btn-danger btn-sm">

                        </form>
                    </td>

                </tr>
            @endforeach
        </tbody>
        </table>
@endsection