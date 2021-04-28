@extends('layouts.global')

@section('title')
    Trashed Categories
@endsection

@section('content')
    <h2>Trashed Categories</h2>

    <div class="row">
        <div class="col-md-4">
            <form action="{{route('categories.index')}}">
                <div class="input-group">
                    <input
                        value="{{Request::get('keyword')}}"
                        name="keyword"
                        class="form-control"
                        type="text"
                        placeholder="Masukan category untuk filter..."/>
                        <div class="input-group-append">
                            <input
                                type="submit"
                                value="Filter" 
                                class="btn btn-primary">
                        </div>
                </div>
            </form>
        </div>

        <div class="col-md-6">
            <ul class="nav nav-pills card-header-pills">
                <li class="nav-item">
                    <a 
                        class="nav-link" 
                        href="{{ route('categories.index') }}">Published
                    </a>
                </li>

                
                <li class="nav-item">
                    <a
                        class="nav-link active"
                        href="{{ route('categories.trash') }}">Trash
                    </a>
                </li>
            </ul>
        </div>

    </div><br>

    <div class="row">
        <div class="col-md-12 text-right">
            <a 
                href="{{ route('categories.create') }}"
                class="btn btn-primary ">
            Create Category
            </a>
        </div>
    </div><br>

    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th><b>Category</b></th>
                <th><b>Slug</b></th>
                <th><b>Category Image</b></th>
                <th><b>Action</b></th>
            </tr>
        </thead>

        <tbody>
            @foreach($categories as $categori)
                <tr>
                    <td>{{ $categori->name }}</td>
                    <td>{{ $categori->slug }}</td>
                    <td>
                        @if($categori->image)
                            <img 
                                src="{{ asset('storage/'.$categori->image) }}"
                                width="70px"/> 
                        @else
                            N/A
                        @endif
                    </td>
                    <td>
                        <a
                            class="btn btn-success btn-sm"
                            href="{{ route('categories.restore', ['id' => $categori->id]) }}">
                            Restore
                        </a>
                        
                        <form 
                            action="{{ route('categories.delete-permanent',['id' => $categori->id]) }}" 
                            method="POST" 
                            class="d-inline"
                            onsubmit="return confirm('Category delete permanent ?')">
                            @csrf
                            @method('DELETE')

                            <input
                                type="submit"
                                class="btn btn-danger btn-sm"
                                value="Delete">
                        </form>
                    </td>

                </tr>
            @endforeach
        </tbody>

        <tfoot>
            <tr>
                <td colspan="10">
                    {{ $categories->appends(Request::all())->links() }}
                </td>
            </tr>
        </tfoot>
        </table>
@endsection