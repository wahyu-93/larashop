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
            action="{{ route('categories.store') }}" 
            method="POST" 
            enctype="multipart/form-data"
            class="bg-white shadow-sm p-3">
            @csrf

            <label for="name"> Category Name </label>
            <input  
                class="form-control"
                placeholder="Full Name"
                type="text"
                name="name"
                id="name"
                value="{{ old('name') }}"
                required>
            <br>

            <label for="image">Category Image</label>
            <input
                type="file"
                name="image"
                id="image"
                class="form-control">
            <hr class="my-3">

            <input 
                type="submit"
                class="btn btn-primary"
                value="Save">
        </form>
    </div>
@endsection