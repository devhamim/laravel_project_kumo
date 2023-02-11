@extends('layouts.dashbord')

@section('content')

{{-- bradecum --}}
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('prodact.list') }}">Product</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Inventory</a></li>
    </ol>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h2>Prodact List</h2>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <tr>
                        <th>SL</th>
                        <th>Product Name</th>
                        <th>Color Name</th>
                        <th>Size Name</th>
                        <th>Quantity</th>
                    </tr>
                    @foreach ($inventoryes as $key=>$inventory)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $inventory->rel_to_prodact->prodact_name }}</td>
                            <td>
                                <span class="badge badge-pill" style="background-color: {{ $inventory->rel_to_color->color_name }}">Primary</span>
                            </td>
                            <td>{{ $inventory->rel_to_size->size_name }}</td>
                            <td>{{ $inventory->quantity }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        @if(session('success_invn'))
            <div class="alert alert-success">{{ session('success_invn') }}</div>
        @endif
        <div class="card">
            <div class="card-header">
                <h2>Prodact Inventory</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('inventory.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="" class="form-label">Product Name</label>
                        <input type="text" readonly class="form-control" value="{{ $prodact_info->prodact_name }}">
                        <input type="hidden" name="prodact_id" class="form-control" value="{{ $prodact_info->id }}">
                    </div>
                    <div class="form-group">
                        <select name="color_id" class="form-control" id="">
                            <option>-- Select Color --</option>
                            @foreach ($colors as $color)
                            <option value="{{ $color->id }}">{{ $color->color_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="size_id" class="form-control" id="">
                            <option>-- Select Color --</option>
                            @foreach ($sizes as $size)
                            <option value="{{ $size->id }}">{{ $size->size_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">Quantity</label>
                        <input type="number"  class="form-control" name="quantity">
                    </div>
                    <div class="form-group">
                       <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
