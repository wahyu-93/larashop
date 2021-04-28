@extends('layouts.global')

@section('title')
    Create Category
@endsection

@section('content')
    <div class="col-md-8">
        @if(session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form 
            action="{{ route('categories.update', ['id' => $category->id]) }}" 
            method="POST" 
            enctype="multipart/form-data"
            class="bg-white shadow-sm p-3">
            @csrf
            @method('PUT')

            <label for="name"> Category Name </label>
            <input  
                class="form-control"
                placeholder="Full Name"
                type="text"
                name="name"
                id="name"
                value="{{ $category->name }}"
                required>
            <br>

            <label for="name"> Category Slug </label>
            <input  
                class="form-control"
                placeholder="Full Name"
                type="text"
                name="slug"
                id="slug"
                value="{{ $category->slug }}"
                required>
            <br>

            <label for="image">Category Image</label><br>
            @if($category->image)
                <span>Current Image</span><br>
                <img 
                    src="{{ asset('storage/'.$category->image) }}"
                    width="220px"><br><br>
            @endif
            <input
                type="file"
                name="image"
                id="image"
                class="form-control">
            <small class="text-muted">Abaikan jika tidak ingin mengubah gambar</small>
            <hr class="my-3">

            <input 
                type="submit"
                class="btn btn-primary"
                value="Save">
        </form>
    </div>
@endsection