@extends('layouts.dashbord')

@section('content')

{{-- bradecum --}}
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('prodact.list') }}">Product</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Variation</a></li>
    </ol>
</div>

<div class="row">
    <div class="col-lg-6">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="card">
            <div class="card-header">
                <h2>Prodact Color</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('variation.store') }}" method="POST" >
                    @csrf
                    <div class="form-group">
                        <label for="" class="form-label">Color Name</label>
                        <input type="text" class="form-control" name="color_name">
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">Color Code</label>
                        <input type="text" class="form-control" name="color_code">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" name="btn" value="1">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        @if(session('success_size'))
            <div class="alert alert-success">{{ session('success_size') }}</div>
        @endif
        <div class="card">
            <div class="card-header">
                <h2>Prodact Size</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('variation.store') }}" method="POST" >
                    @csrf
                    <div class="form-group">
                        <label for="" class="form-label">Size Name</label>
                        <input type="text" class="form-control" name="size_name">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" name="btn2" value="2">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h2></h2>
            </div>
            <div class="card-body">
                <div class="card">
                    <div class="card-header">
                        <h2>Color List</h2>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <tr>
                                <th>SL</th>
                                <th>Color Name</th>
                                <th>Color</th>
                            </tr>
                            @foreach ($colors as $key=>$color)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $color->color_name }}</td>
                                    <td>
                                        <span class="badge badge-pill" style="background-color: #{{ $color->color_code }}">Primary</span>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h2></h2>
            </div>
            <div class="card-body">
                <div class="card">
                    <div class="card-header">
                        <h2>Size List</h2>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <tr>
                                <th>SL</th>
                                <th>Size Name</th>
                            </tr>
                            @foreach ($sizes as $key=>$size)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $size->size_name }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


@endsection
