@extends('layouts.dashbord')

@section('content')

{{-- bradecum --}}
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Coupon</a></li>
    </ol>
</div>

<div class="container">
    <div class="row">
        <div class="col-lg-8">
            @if(session('coupon_delete'))
                <div class="alert alert-success">{{ session('coupon_delete') }}</div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h2>Coupon List</h2>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <tr>
                            <th>SL</th>
                            <th>Coupon Name</th>
                            <th>Discoun</th>
                            <th>Expired Date</th>
                            <th>Type</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($coupons as $key=>$coupon)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $coupon->coupon_name }}</td>
                            <td>{{ $coupon->discount }} {{ $coupon->type == 1?'%':'TK' }}</td>
                            <td>{{ $coupon->expired }} </td>
                            <td>{{ $coupon->type }} </td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{ route('coupon.delete', $coupon->id) }}" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
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
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h2>Coupon</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('coupon.store') }}" method="POST">
                        @csrf
                        <div class="my-3">
                            <label for="" class="form-label">Coupon Name</label>
                            <input type="text" name="coupon_name" class="form-control" placeholder="Coupon">
                        </div>
                        <div class="my-3">
                            <label for="" class="form-label">Discount</label>
                            <input type="number" name="discount" class="form-control" placeholder="Discount %">
                        </div>
                        <div class="my-3">
                            <label for="" class="form-label">Expired</label>
                            <input type="date" name="expired" class="form-control">
                        </div>
                        <div class="my-3">
                            <select name="type" class="form-control">
                                <option value="">-- Select Type --</option>
                                <option value="1">Percentage</option>
                                <option value="2">Solid Amount</option>
                            </select>
                        </div>
                        <div class="my-3">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
