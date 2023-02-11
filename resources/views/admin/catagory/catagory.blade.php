@extends('layouts.dashbord')

@section('content')

    <div class="">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Statistics</a></li>
            </ol>
        </div>
        <div class="row">
            <div class="col-lg-9">
                @if (session('success_delete'))
                    <div class="alert alert-success">{{ session('success_delete') }}</div>
                @endif
                <div class="card">
                    <div class="card-header">
                        <h2>Catagory List</h2>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <tr>
                                <th>no</th>
                                <th>Catagory Name</th>
                                <th>Addad By</th>
                                <th>Catagoey Image</th>
                                <th>Catagoey Icon</th>
                                <th>Action</th>
                            </tr>
                            @foreach ($catagoris as $sl=>$catagori)
                            <tr>
                                <td>{{ $sl+1 }}</td>
                                <td>{{ $catagori->catagory_name}}</td>
                                {{-- <td>{{ $catagori->relation_to_user->name}}</td> --}}
                                <td>
                                    @if(App\Models\User::where('id', $catagori->addad_by)->exists())
                                        {{ $catagori->relation_to_user->name}}
                                    @else
                                        <strong class="text-danger">Unknown</strong>
                                    @endif
                                </td>
                                <td>
                                    <img width="50" src="{{ asset('uplodes/catagory_img') }}/{{ $catagori->catagory_img}}" alt="">
                                </td>
                                <td>
                                    <i class="{{ $catagori->category_icon }}"></i>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
                                            <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                        </button>
                                        <div class="dropdown-menu">
                                            @can('catagory_edit')
                                                <a class="dropdown-item" href="{{ route('catagory.edit', $catagori->id) }}">Edit</a>
                                            @endcan
                                            @can('cetagory_delete')
                                                <a class="dropdown-item" href="{{ route('catagory.delete', $catagori->id) }}">Delete</a>
                                            @endcan
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @can('category_add')
                <div class="card">
                    <div class="card-header">
                        <h2>Catagory Add</h2>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('catagory.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="my-3">
                                <label for="" class="form-label">Catagory Icon</label>
                                @php
                                        $icons = [

                                        'fa-apple',
                                        'fa-language',
                                        'fa-fax',
                                        'fa-recycle',
                                        'fa-car',
                                        'fa-taxi',
                                        'fa-tree',
                                        'fa-file-audio-o',
                                        'fa-file-video-o',
                                        'fa-font-awesome',
                                        'fa-shopping-bag',
                                        'fa-paint-brush',
                                        'fa-book',
                                        'fa-bed',
                                        'fa-cutlery',
                                        'fa-futbol-o',
                                        'fa-mobile',
                                        'fa-television',
                                        'fa-bolt',
                                        ];
                                        @endphp
                                <div class="my-3" style="font-family: fontawesome; font-size: 22px; " >
                                    @foreach ($icons as $icon)
                                        <i class="fa {{ $icon }} px-1" data-icon="{{ $icon }}"></i>
                                    @endforeach
                                </div>
                                <input type="text" id="icon" class="form-control" name="category_icon" placeholder="Category Icon">
                                @error('category_icon')
                                    <strong class="text-danger">{{ $message }}</strong>
                                @enderror
                            </div>
                            <div class="my-3">
                                <label for="" class="form-label">Catagory Name</label>
                                <input type="text" class="form-control" name="catagory_name" placeholder="Category name">
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
                @endcan
            </div>
        </div>
    </div>

@endsection

@section('footer_scrip')
    <script>
        $('.fa').click(function(){
            var icon = $(this).attr('data-icon');
            $('#icon').attr('value', icon);
        });
    </script>
@endsection

