@extends('layouts.dashbord')

@section('content')

    <div class="">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Subcatagory</a></li>
            </ol>
        </div>
        <div class="row">
            <div class="col-lg-9">
                @if (session('success_delete'))
                    <div class="alert alert-success">{{ session('success_delete') }}</div>
                @endif
                <div class="card">
                    <div class="card-header">
                        <h2>Sub Catagory List</h2>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <tr>
                                <th>no</th>
                                <th>Catagory</th>
                                <th>Sub Catagory</th>
                                <th>Catagoey Image</th>
                                <th>Action</th>
                            </tr>
                            @foreach ($subcatagories as $sl=>$subcatagory)
                            <tr>
                                <td>{{ $sl+1 }}</td>
                                <td>
                                    @if(App\Models\catagory::where('id', $subcatagory->catagory_id)->exists())
                                        {{ $subcatagory->rel_to_subcatagory->catagory_name }}
                                    @else
                                        <strong class="text-danger">Unknown</strong>
                                    @endif
                                    {{-- {{ $subcatagory->rel_to_subcatagory->catagory_name}} --}}
                                </td>
                                <td>{{ $subcatagory->subcatagory_name}}</td>
                                <td><img width="50" src="{{ asset('uplodes/subcatagory') }}/{{ $subcatagory->subcatagory_img}}" alt=""></td>
                                <td>
                                    <div class="d-flex">
                                        @can('subcategory_edit')
                                            <a href="{{ route('subcatagory.edit', $subcatagory->id) }}" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
                                        @endcan
                                        @can('subcategory_delete')
                                            <a href="{{ route('subcatagory.delete', $subcatagory->id) }}" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
                                        @endcan
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
                @can('subcategory_add')
                <div class="card">
                    <div class="card-header">
                        <h2>Sub Catagory Add</h2>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('subcatagory.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="my-3">
                                <select name="catagory_id" class="form-control">
                                    <option value=""> -- Select Catagory --</option>
                                    @foreach ($catagories as $catagory)
                                        <option value="{{ $catagory->id }}">{{ $catagory->catagory_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="my-3">
                                <label for="" class="form-label">SubCatagory Name</label>
                                <input type="text" class="form-control" name="subcatagory_name">
                                @error('subcatagory_name')
                                    <strong class="text-danger">{{ $message }}</strong>
                                @enderror
                            </div>
                            <div class="my-3">
                                <label for="" class="form-label">SubCatagory Image</label>
                                <input type="file" class="form-control" name="subcatagory_img">
                                @error('subcatagory_img')
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


