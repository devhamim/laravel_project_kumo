@extends('layouts.dashbord')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('subcatagory') }}">Subcatagory</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Subcatagory Trash</a></li>
    </ol>
</div>
    <div class="row">
        <div class="col-lg-10">
            @if (session('success_delete'))
                <div class="alert alert-success">{{ session('success_delete') }}</div>
            @endif
            @if(session('restore'))
                <div class="alert alert-success">{{ session('restore') }}</div>
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
                        @foreach ($subcatagory_trash as $sl=>$subcatagory)
                        <tr>
                            <td>{{ $sl+1 }}</td>
                            <td>
                                @if(App\Models\catagory::where('id', $subcatagory->catagory_id)->exists())
                                        {{ $subcatagory->rel_to_subcatagory->catagory_name }}
                                    @else
                                        <strong class="text-danger">Unknown</strong>
                                    @endif
                            </td>
                            <td>{{ $subcatagory->subcatagory_name}}</td>
                            <td>
                                <img width="50" src="{{ asset('uplodes/subcatagory') }}/{{ $subcatagory->subcatagory_img}}" alt="">
                            </td>
                            <td>
                                <div class="d-flex">
                                    @can('subcategory_edit')
                                        <a href="{{ route('subcatagory.restore', $subcatagory->id) }}" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-undo"></i></a>
                                    @endcan
                                    @can('subcategory_delete')
                                        <a href="{{ route('subcatagory.hard.delete', $subcatagory->id) }}" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
