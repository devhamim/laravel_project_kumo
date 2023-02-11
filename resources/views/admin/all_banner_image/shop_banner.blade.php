@extends('layouts.dashbord')

@section('content')
    <div class="row">
        <div class="col-lg-8">
            @if(session('shop_delete'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>
                    <strong>Success!</strong> {{ session('shop_delete') }}
                    <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                    </button>
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h2>shop Banner Image</h2>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <tr>
                            <th>SL.</th>
                            <th>Shop Banner Image</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($shop_banner as $sl=>$shop)
                        <tr>
                            <td>{{ $sl+1 }}</td>
                            <td>
                                <img width="150px" src="{{ asset('uplodes/shop_banner') }}/{{ $shop->banner_img }}" alt="">
                            </td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{ route('shop.banner.delete', $shop->id) }}" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
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
                    <h2>Add Shop Banner Image</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('shop.banner.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="my-3">
                            <label for="" class="form-label">Shop Banner</label>
                            <input type="file" name="shop_banner" class="form-control" placeholder="Shop Banner">
                        </div>
                        <div class="my-3">
                            <button type="submit" class="btn btn-primary">Shop Banner</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
