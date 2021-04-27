@extends('layouts.global')

@section('title')
    Category List
@endsection

@section('content')
    <h2>Category List</h2>

    <div class="row">
        <div class="col-md-6">
            <form action="{{route('categories.index')}}">
                <div class="row">
                    <div class="col-md-6">
                        <input
                            value="{{Request::get('keyword')}}"
                            name="keyword"
                            class="form-control"
                            type="text"
                            placeholder="Masukan category untuk filter..."/>
                    </div>

                    <div class="col-md-6">                       
                        <input
                            type="submit"
                            value="Filter" 
                            class="btn btn-primary">
                    </div>
                </div>
            </form>
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
                            class="btn btn-info text-white btn-sm"
                            href="{{ route('categories.edit', ['id' => $categori->id]) }}">
                            Edit
                        </a>
                        &nbsp;
                        <form
                            onsubmit="return confirm('Delete this categori permanently ?')"
                            class="d-inline"
                            action="{{ route('categories.destroy', ['id' => $categori->id]) }}"
                            method="POST">
                            @csrf
                            @method('DELETE')

                            <input type="submit" value="delete" class="btn btn-danger btn-sm">

                        </form>
                        &nbsp;
                        <a
                            class="btn btn-primary btn-sm"
                            href="{{ route('categories.show', ['id' => $categori->id]) }}">
                        Detail
                        </a>
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