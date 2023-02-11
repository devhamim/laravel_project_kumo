@extends('layouts.dashbord')

@section('content')
    <div class="row">
        <div class="col-lg-4 m-auto">
            @can('profile_update')
            <div class="card">
                <div class="card-header">
                    <h2>Profile Update</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        <div class="my-3">
                            <label for="" class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}">
                        </div>
                        <div class="my-3">
                            <label for="" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ Auth::user()->email }}">
                        </div>
                        <div class="my-3">
                            <button class="btn btn-primary" type="submit">Update</button>
                        </div>
                    </form>
                </div>
            </div>
            @endcan
        </div>
        <div class="col-lg-4 m-auto">
            @if(session('confirm_password'))
                <div class="alert alert-success">{{ session('confirm_password') }}</div>
            @endif
            @can('profile_password')
            <div class="card">
                <div class="card-header">
                    <h2>Password Update</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.password.update') }}" method="POST">
                        @csrf
                        <div class="my-3">
                            <label for="" class="form-label">Old Password</label>
                            <input type="password" name="old_password" class="form-control" >
                            @error('old_password')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                            @if(session('old_password'))
                                <strong class="text-danger">{{ session('old_password') }}</strong>
                            @endif
                        </div>
                        <div class="my-3">
                            <label for="" class="form-label">New Password</label>
                            <input type="password" name="password" class="form-control" >
                            @error('password')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="my-3">
                            <label for="" class="form-label">Conform Password</label>
                            <input type="password" name="password_confirmation" class="form-control" >
                            @error('password_confirmation')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="my-3">
                            <button class="btn btn-primary" type="submit">Update</button>
                        </div>
                    </form>
                </div>
            </div>
            @endcan
        </div>
        <div class="col-lg-4 m-auto">
        @if(session('photo_uplode'))
            <div class="alert alert-success">{{ session('photo_uplode') }}</div>
        @endif
        @if(session('photo_update'))
            <div class="alert alert-success">{{ session('photo_update') }}</div>
        @endif
        @can('profile_photo')
            <div class="card">
                <div class="card-header">
                    <h2>Profile Photo</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('photo.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="my-3">
                            <label for="" class="form-label">Photo</label>
                            <input type="file" name="photo" class="form-control">
                        </div>
                        <div class="my-3">
                            <button class="btn btn-primary" type="submit">Update</button>
                        </div>
                    </form>
                </div>
            </div>
            @endcan
        </div>
    </div>
@endsection
