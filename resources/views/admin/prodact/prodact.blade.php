@extends('layouts.dashbord')

@section('content')

{{-- bradecum --}}
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Product</a></li>
    </ol>
</div>

<div class="">
    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-12">
            @if(session('delete_success'))
                <div class="alert alert-success">{{ session('delete_success') }}</div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h2>Product List</h2>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <th>SL</th>
                            <th>Product Name</th>
                            <th>Brand</th>
                            <th>Category</th>
                            <th>Subcategory</th>
                            <th>Preview</th>
                            <th>Thumbnail</th>
                            <th>price</th>
                            <th>discount</th>
                            <th>Total Price</th>
                            <th>Action</th>
                        </tr>

                        @foreach ($prodacts as $key=>$prodact)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $prodact->prodact_name }}</td>
                                <td>{{ $prodact->prodact_brand }}</td>
                                <td>{{ $prodact->rel_to_category->catagory_name }}</td>
                                <td>{{ $prodact->rel_to_subcategory->subcatagory_name }}</td>
                                <td>
                                    <img width="50" src="{{ asset('uplodes/prodact/preview') }}/{{ $prodact->preview }}" alt="">
                                </td>
                                <td>
                                    @foreach (App\Models\thumbnail::where('prodact_id', $prodact->id)->get() as $thumbnail)
                                        <img width="20" src="{{ asset('uplodes/prodact/thumbnail') }}/{{ $thumbnail->thumbnail }}" alt="">
                                    @endforeach
                                </td>
                                <td>{{ $prodact->price }}</td>
                                <td>{{ $prodact->discount }}%</td>
                                <td>{{ $prodact->after_discount }}</td>
                                <td>
                                    <div class="d-flex">
                                        @can('product_edit')
                                            <a href="{{ route('prodact.inventory', $prodact->id) }}" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
                                        @endcan
                                        @can('product_delete')

                                            <a href="{{ route('prodact.delete', $prodact->id) }}" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
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
</div>

@endsection
