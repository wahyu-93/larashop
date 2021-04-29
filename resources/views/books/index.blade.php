@extends('layouts.global')

@section('title')
    Books List
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3">
                <div class="col-md-12 text-right">
                    <a 
                        href="{{ route('books.create') }}"
                        class="btn btn-primary">Create Book
                    </a>
                </div>
            </div>
            
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
                            <td>TODO : actions</td>
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