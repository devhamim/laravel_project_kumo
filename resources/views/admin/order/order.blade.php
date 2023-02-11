@extends('layouts.dashbord');

@section('content')

{{-- bradecum --}}
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Product</a></li>
    </ol>
</div>

{{-- main  --}}
<div class="row">
    <div class="col-lg-12">
        <div class="card-header">
            <h2>Order List</h2>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <tr>
                    <th>SL</th>
                    <th>Order Id</th>
                    <th>Customer</th>
                    <th>Sub total</th>
                    <th>Total</th>
                    <th>Discount</th>
                    <th>Charge</th>
                    <th>Status</th>
                    <th>Order Date</th>
                    <th>Action</th>
                </tr>
                @foreach ($customer_order as $sl=>$order)
                <tr>
                    <td>{{ $sl+1 }}</td>
                    <td>{{ $order->order_id }}</td>
                    <td>{{ $order->rel_to_customer->name }}</td>
                    <td>{{ $order->sub_total }}</td>
                    <td>{{ $order->total }}</td>
                    <td>{{ $order->discount }}</td>
                    <td>{{ $order->charge }}</td>
                    <td>
                        @php
                            if($order->status == 1){
                                echo '<span class="badge badge-info">Placed</span>';
                            }
                            elseif ($order->status == 2) {
                                echo '<span class="badge badge-secondary">Processing</span>';
                            }
                            elseif ($order->status == 3) {
                                echo '<span class="badge badge-primary">Packeging</span>';
                            }
                            elseif ($order->status == 4) {
                                echo '<span class="badge badge-warning ">Ready To Deliver</span>';
                            }
                            elseif ($order->status == 5) {
                                echo '<span class="badge badge-dark">Shipping</span>';
                            }
                            else {
                                echo '<span class="badge badge-success">Delivered</span>';
                            }
                        @endphp
                    </td>
                    <td>{{ $order->created_at->format('d-m-Y') }}</td>
                    <td>
                        @can('order_status_edit')
                        <div class="dropdown">
                            <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
                                <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                            </button>
                            <div class="dropdown-menu">
                            <form action="{{ route('order.status') }}" method="POST">
                            @csrf
                                <button name="status" value="{{ $order->order_id .','. '1' }}" class="dropdown-item status">Placed</button>
                                <button name="status" value="{{ $order->order_id .','. '2' }}" class="dropdown-item status">Processing</button>
                                <button name="status" value="{{ $order->order_id .','. '3' }}" class="dropdown-item status">Packeging</button>
                                <button name="status" value="{{ $order->order_id .','. '4' }}" class="dropdown-item status">Ready To Deliver</button>
                                <button name="status" value="{{ $order->order_id .','. '5' }}" class="dropdown-item status">Shipping</button>
                                <button name="status" value="{{ $order->order_id .','. '6' }}" class="dropdown-item status">Delivered</button>
                            </div>
                        </div>
                        @endcan
                    </td>
                </tr>
                @endforeach

            </form>
            </table>
        </div>
    </div>
</div>

@endsection
