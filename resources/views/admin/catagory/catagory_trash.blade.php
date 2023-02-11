@extends('layouts.dashbord')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('catagory') }}">Catagory</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Catagory Trash</a></li>
    </ol>
</div>
    <div class="row">
        <div class="col-lg-10">
            @if (session('success_delete'))
                <div class="alert alert-success">{{ session('success_delete') }}</div>
            @endif
            @if(session('success_restore'))
                <div class="alert alert-success">{{ session('success_restore') }}</div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h2>Trash Catagory List</h2>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <tr>
                            <th>no</th>
                            <th>Catagory Name</th>
                            <th>Addad By</th>
                            <th>Catagoey Image</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($catagory_trash as $sl=>$catagori)
                        <tr>
                            <td>{{ $sl+1 }}</td>
                            <td>{{ $catagori->catagory_name}}</td>
                            <td>
                                @if(App\Models\User::where('id', $catagori->addad_by)->exists())
                                {{ $catagori->relation_to_user->name}}
                                @else
                                    <strong class="text-danger">Unknown</strong>
                                @endif
                            </td>
                            <td><img width="50" src="{{ asset('uplodes/catagory_img') }}/{{ $catagori->catagory_img}}" alt=""></td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
                                        <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('catagory.restore', $catagori->id) }}">Restore</a>
                                        <a class="dropdown-item" href="{{ route('catagory.hard.delete', $catagori->id) }}">Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        {{-- <div class="col-lg-3">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h2>Catagory Add</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('catagory.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="my-3">
                            <label for="" class="form-label">Catagory Name</label>
                            <input type="text" class="form-control" name="catagory_name">
                            @error('catagory_name')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="my-3">
                            <label for="" class="form-label">Catagory Image</label>
                            <input type="file" class="form-control" name="catagory_img">
                            @error('catagory_img')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="my-3">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div> --}}
    </div>
@endsection
