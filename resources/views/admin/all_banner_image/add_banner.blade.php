@extends('layouts.dashbord')

@section('content')
    <div class="row">
        <div class="col-lg-8">
            @if(session('ban_delete'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>
                    <strong>Success!</strong> {{ session('ban_delete') }}
                    <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                    </button>
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h2>Banner Image</h2>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <tr>
                            <th>SL.</th>
                            <th>Banner type</th>
                            <th>Banner title</th>
                            <th>Banner Description</th>
                            <th>Banner Image</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($banner_img as $sl=>$banner)
                        <tr>
                            <td>{{ $sl+1 }}</td>
                            <td>{{ $banner->banner_type }}</td>
                            <td>{{ $banner->banner_title }}</td>
                            <td>{{ $banner->banner_desp }}</td>
                            <td>
                                <img width="150px" src="{{ asset('uplodes/banner') }}/{{ $banner->banner_img }}" alt="">
                            </td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{ route('banner.delete', $banner->id) }}" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>
                    <strong>Success!</strong> {{ session('success') }}
                    <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                    </button>
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h2>Add Banner Image</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('banner.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="my-3">
                            <label for="" class="form-label">Banner Type</label>
                            <input type="text" name="banner_type" class="form-control" placeholder="Banner type">
                        </div>
                        <div class="my-3">
                            <label for="" class="form-label">Banner Title</label>
                            <input type="text" name="banner_title" class="form-control" placeholder="Banner title">
                        </div>
                        <div class="my-3">
                            <label for="" class="form-label">Banner Description</label>
                            <input type="text" name="banner_desp" class="form-control" placeholder="Banner Description">
                        </div>
                        <div class="my-3">
                            <label for="" class="form-label">Banner Image</label>
                            <input type="file" name="banner_img" class="form-control" placeholder="Banner Image">
                        </div>
                        <div class="my-3">
                            <button type="submit" class="btn btn-primary">Banner Image</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
