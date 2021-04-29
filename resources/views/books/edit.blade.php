@extends('layouts.global')

@section('title')
    Edit Book
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            @if(session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <form
                action="{{route('books.update', ['id' => $book->id])}}"
                method="POST"
                enctype="multipart/form-data"
                class="shadow-sm p-3 bg-white">
                @csrf
                @method('PUT')

                <label for="title">Title</label> <br>
                <input 
                    type="text" 
                    class="form-control" 
                    name="title"
                    placeholder="Book title"
                    value="{{ $book->title }}">
                <br>
                
                <label for="cover">Cover</label>
                <small class="text-muted">Current Cover</small><br>
                @if($book->cover)
                    <img 
                        src="{{ asset('storage/'.$book->cover) }}"
                        width="96px">
                @endif
                <br><br>
                <input type="file" class="form-control" name="cover">
                <small class="text-muted">Kosongkan jika tidak ingin mengubah cover</small>
                <br><br>

                <label for="slug">Slug</label><br>
                <input 
                    type="text"
                    class="form-control"
                    value="{{ $book->slug }}"
                    name="slug"
                    id="slug"
                    placeholder="enter-a-slug">
                <br>

                <label for="description">Description</label><br>
                <textarea 
                    name="description" 
                    id="description" 
                    class="form-control"
                    placeholder="Give a description about this book">{{ $book->description }}</textarea>
                <br>

                <label for="categories">Categories</label><br>
                <select
                    name="categories[]"
                    id="categories"
                    class="form-control"
                    multiple>
                </select>
                <br>

                <label for="stock">Stock</label><br>
                <input 
                    type="number" 
                    class="form-control" 
                    id="stock" 
                    name="stock"
                    min=0 
                    value={{ $book->stock }}>
                <br>

                <label for="author">Author</label><br>
                <input 
                    type="text" 
                    class="form-control" 
                    name="author" 
                    id="author"
                    placeholder="Book author"
                    value="{{ $book->author }}">
                <br>

                <label for="publisher">Publisher</label> <br>
                <input 
                    type="text" 
                    class="form-control" 
                    id="publisher"
                    name="publisher" 
                    placeholder="Book publisher"
                    value="{{ $book->publisher }}">
                <br>

                <label for="Price">Price</label> <br>
                <input 
                    type="number" 
                    class="form-control" 
                    name="price" 
                    id="price"
                    placeholder="Book price"
                    value="{{ $book->price }}">
                <br>

                <label for="status">Status</label><br>
                <select 
                    name="status"
                    id="status"
                    class="form-control">
                    <option {{ $book->status=="PUBLISH" ? 'selected' : '' }} value="PUBLISH">PUBLISH</option>
                    <option {{ $book->status=="DRAFT" ? 'selected' : '' }} value="DRAFT">DRAFT</option>
                </select>
                <br>

                <button
                    class="btn btn-primary"
                    value="PUBLISH">Update
                </button>
            </form>
        </div>
    </div>
@endsection

@section('footer-scripts')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

    <script>
        $('#categories').select2({
            ajax : {
                url : '/ajax/categories/search',
                processResults : function(data){
                    return {
                        results: data.map(function(item){
                            return {
                                id: item.id,
                                text: item.name
                            }
                        })
                    }
                }
            }
        });

        var categories = {!! $book->categories !!}
        categories.forEach(function(category){
            var option = new Option(category.name, category.id, true, true);
            $('#categories').append(option).trigger('change');
        });
    </script>
@endsection
