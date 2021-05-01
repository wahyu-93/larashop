@extends('layouts.global')

@section('title')
    Books List
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <form action="{{ route('books.index') }}">
                        <div class="input-group">
                            <input 
                                type="text"
                                class="form-control"
                                name="keyword"
                                id="keyword"
                                placeholder="Filter by title"
                                value="{{ Request::get('keyword') }}">
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
                                class="nav-link {{ Request::get('status') == NULL && Request::path() == 'books' ? 'active' : '' }} "     
                                href="{{ route('books.index') }}">
                            ALL
                            </a>
                        </li>

                        <li class="nav-item">
                            <a 
                                class="nav-link {{ Request::get('status') == 'publish' ? 'active' : '' }}"    
                                href="{{ route('books.index', ['status' => 'publish']) }}">
                            Publish
                            </a>
                        </li>

                        <li class="nav-item">
                            <a 
                                class="nav-link {{ Request::get('status') == 'draft' ? 'active' : '' }}"    
                                href="{{ route('books.index', ['status' => 'draft']) }}">
                            Draft
                            </a>
                        </li>

                        <li class="nav-item">
                            <a 
                                class="nav-link {{ Request::path() == 'books/trash' ? 'active' : '' }}"    
                                href="{{ route('books.trash') }}">
                            Trash
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="mb-3">
                <div class="col-md-12 text-right">
                    <a 
                        href="{{ route('books.create') }}"
                        class="btn btn-primary">Create Book
                    </a>
                </div>
            </div>

            @if(session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div> 
            @endif
            
            <table class="table table-bordered table-stripped">
                <thead>
                    <tr>
                        <th><b>Cover</b></th>
                        <th><b>Title</b></th>
                        <th><b>Author</b></th>
                        <th><b>Status</b></th>
                        <th><b>Categories</b></th>
                        <th><b>Stock</b></th>
                        <th><b>Price</b></th>
                        <th><b>Action</b></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($books as $book)
                        <tr>
                            <td>
                                @if($book->cover)
                                    <img    
                                        src="{{ asset('storage/'.$book->cover) }}"
                                        width="96px">
                                @endif
                            </td>
    
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->author }}</td>
                            <td>
                                @if($book->status == "DRAFT")
                                    <span class="badge badge-dark text-white">{{ $book->status }}
                                @else
                                    <span class="badge badge-success text-white">{{ $book->status }}
                                @endif
                            </td>
    
                            <td>
                                <ul class="pl-3">
                                    @foreach($book->categories as $category)
                                        <li>{{ $category->name }}</li>
                                    @endforeach
                                </ul>
                            </td>
    
                            <td>{{ $book->stock }}</td>
                            <td>{{ $book->price }}</td>
                            <td>
                                <a
                                    href="{{ route('books.edit',['id' => $book->id]) }}"
                                    class="btn btn-info btn-sm">Edit
                                </a>

                                <form 
                                    action="{{ route('books.destroy', ['id' => $book->id]) }}" 
                                    method="POST" 
                                    class="d-inline"
                                    onsubmit="return confirm('Move to trash ?')">
                                    @csrf
                                    @method('DELETE')

                                    <input 
                                        type="submit"
                                        class="btn btn-danger btn-sm"
                                        value="Trash">
                                </form>

                            </td>
                        </tr>
                    @endforeach
                </tbody>

                <tfoot>
                    <tr>
                        <td colspan="10">
                            {{ $books->appends(Request::all())->links() }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection