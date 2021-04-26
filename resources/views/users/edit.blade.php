@extends('layouts.global')

@section('title')
    Edit User
@endsection

@section('content')
    <div class="col-md-8">
        @if(session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form 
            action="{{ route('users.update', ['id' => $user->id]) }}" 
            method="POST" 
            enctype="multipart/form-data"
            class="bg-white shadow-sm p-3">
            @csrf
            @method('PUT')

            <label for="name"> Name </label>
            <input  
                class="form-control"
                placeholder="Full Name"
                type="text"
                name="name"
                id="name"
                value="{{ $user->name }}">
            <br>

            <label for="username"> Username </label>
            <input  
                class="form-control"
                placeholder="Username"
                type="text"
                name="username"
                id="username"
                value="{{ $user->username }}"
                disabled>
            <br>

            <label for="">Status</label>
            <br>
            <input 
                type="radio"
                name="status"
                id="active"
                class="form-control"
                value="ACTIVE"
                {{ $user->status=="ACTIVE" ? 'checked' : '' }}>
                <label for="active">Active</label>
            <br>

            <input 
                type="radio"
                name="status"
                id="inactive"
                class="form-control"
                value="INACTIVE"
                {{ $user->status=="INACTIVE" ? 'checked' : '' }}>
                <label for="inactive">Inactive</label>
            <br><br>

            <label for=""> Roles </label>
            <br>
            <input
                type="checkbox"
                name="roles[]"
                id="ADMIN"
                value="ADMIN"
                {{ in_array('ADMIN', json_decode($user->roles)) ? 'checked' : '' }}>
                <label for="ADMIN">Administrator </label>
            
            <input
                type="checkbox"
                name="roles[]"
                id="STAFF"
                value="STAFF"
                {{ in_array('STAFF', json_decode($user->roles)) ? 'checked' : '' }}>
                <label for="STAFF">Staff </label>

            <input
                type="checkbox"
                name="roles[]"
                id="CUSTOMER"
                value="CUSTOMER"
                {{ in_array('CUSTOMER', json_decode($user->roles)) ? 'checked' : '' }}>
                <label for="CUSTOMER">Customer </label>
            <br>

            <br>
            <label for="phone">Phone Number</label>
            <input 
                type="text"
                name="phone"
                id="phone"
                class="form-control"
                value="{{ $user->phone }}">
            <br>

            <label for="address">Address</label>
            <textarea
                name="address"
                id="address"
                class="form-control">{{ $user->address }}
            </textarea>
            <br>

            <label for="avatar">Avatar Image</label>
            <br>
            Current Avatar : <br><br>
            @if($user->avatar)
                <img 
                    src="{{ asset('storage/'. $user->avatar) }}"
                    width="120px" /><br>
            @else
                No Avatar
            @endif
            <br>
            <input
                type="file"
                name="avatar"
                id="avatar"
                class="form-control">
                <small
                    class="text-muted">
                    Kosongkan jika tidak ingin mengubah avatar
                </small>
            <hr class="my-3">

            <label for="email">Email</label>
            <input
                type="email"
                name="email"
                id="email"
                class="form-control"
                placeholder="user@mail.com" 
                value="{{ $user->email }}"
                disabled>
            <br>

            <input 
                type="submit"
                class="btn btn-primary"
                value="Save">
        </form>
    </div>
@endsection