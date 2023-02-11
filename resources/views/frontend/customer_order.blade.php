@extends('frontend.master')

@section('content')

<!-- ======================= Top Breadcrubms ======================== -->
<div class="gray py-3">
    <div class="container">
        <div class="row">
            <div class="colxl-12 col-lg-12 col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">My Order</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- ======================= Top Breadcrubms ======================== -->

<!-- ======================= Dashboard Detail ======================== -->
<section class="middle">
    <div class="container">
        <div class="row align-items-start justify-content-between">

            <div class="col-12 col-md-12 col-lg-4 col-xl-4 text-center miliods">
                <div class="d-block border rounded mfliud-bot">
                    <div class="dashboard_author px-2 py-5">
                        <div class="dash_auth_thumb circle p-1 border d-inline-flex mx-auto mb-2">
                            @if(Auth::guard('customerlogin')->user()->photo == null)
                                <img width="50" src="{{ Avatar::create(Auth::guard('customerlogin')->user()->name)->toBase64() }}" />
                            @else
                                <img src="{{ asset('uplodes/customerprofile/') }}/{{ Auth::guard('customerlogin')->user()->photo }}" class="img-fluid circle" width="100" alt="" />
                            @endif
                        </div>
                        <div class="dash_caption">
                            <h4 class="fs-md ft-medium mb-0 lh-1">{{ Auth::guard('customerlogin')->user()->name }}</h4>
                            <span class="text-muted smalls">{{ Auth::guard('customerlogin')->user()->country }}</span>
                        </div>
                    </div>

                    <div class="dashboard_author">
                        <h4 class="px-3 py-2 mb-0 lh-2 gray fs-sm ft-medium text-muted text-uppercase text-left">Dashboard Navigation</h4>
                        <ul class="dahs_navbar">
                            <li><a href="{{ route('customer.profile') }}" ><i class="lni lni-user mr-2"></i>Profile Info</a></li>
                            <li><a href="{{ route('customer.order') }}" class="active"><i class="lni lni-shopping-basket mr-2"></i>My Order</a></li>
                            <li><a href="{{ route('wish') }}"><i class="lni lni-heart mr-2"></i>Wishlist</a></li>
                            <li><a href="{{ route('customer.logout') }}"><i class="lni lni-power-switch mr-2"></i>Log Out</a></li>
                        </ul>
                    </div>

                </div>
            </div>

            <div class="col-12 col-md-12 col-lg-8 col-xl-8 text-center">
                <!-- Single Order List -->
                @foreach ($order_product as $order)
                <div class="ord_list_wrap border mb-4">
                    <div class="ord_list_head gray d-flex align-items-center justify-content-between px-3 py-3">
                        <div class="olh_flex">
                            <p class="m-0 p-0"><span class="text-muted">Order Number</span></p>
                            <h6 class="mb-0 ft-medium">{{ $order->order_id }}</h6>
                        </div>
                        <div>
                            <a href="{{ route('invoice.download', $order->id) }}" class="badge badge-success p-2">invoice Download</a>
                        </div>
                        <div class="">
                            <p class="mb-1 p-0"><span class="text-muted">Status</span></p>
                            <div class="delv_status"><span class="ft-medium  text-warning rounded px-3 py-1">
                                @php
                                    if($order->status == 1){
                                        echo '<span class="badge badge-info py-2 px-3">Placed</span>';
                                    }
                                    elseif ($order->status == 2) {
                                        echo '<span class="badge badge-secondary py-2 px-3">Processing</span>';
                                    }
                                    elseif ($order->status == 3) {
                                        echo '<span class="badge badge-primary py-2 px-3">Packeging</span>';
                                    }
                                    elseif ($order->status == 4) {
                                        echo '<span class="badge badge-warning py-2 px-3">Ready To Deliver</span>';
                                    }
                                    elseif ($order->status == 5) {
                                        echo '<span class="badge badge-dark py-2 px-3">Shipping</span>';
                                    }
                                    else {
                                        echo '<span class="badge badge-success py-2 px-3">Delivered</span>';
                                    }
                                @endphp
                            </span>
                        </div>
                        </div>
                    </div>
                    <div class="ord_list_body text-left">
                        <!-- First Product -->
                        @php
                            $total = 0;
                        @endphp
                        @foreach (App\Models\orderproduct::where('order_id', $order->order_id)->get() as $order_product)
                        <div class="row align-items-center justify-content-center m-0 py-4 br-bottom">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                <div class="cart_single d-flex align-items-start mfliud-bot">
                                    <div class="cart_selected_single_thumb">
                                        <a href="#"><img src="{{ asset('uplodes/prodact/preview') }}/{{ $order_product->rel_to_prodact->preview }}" width="75" class="img-fluid rounded" alt=""></a>
                                    </div>
                                    <div class="cart_single_caption pl-3">
                                        @php
                                            $category_id = $order_product->rel_to_prodact->catagory_id
                                        @endphp
                                        <p class="mb-0"><span class="text-muted small">{{ App\Models\catagory::where('id', $category_id)->first()->catagory_name }}</span></p>
                                        <h4 class="product_title fs-sm ft-medium mb-1 lh-1">{{ $order_product->rel_to_prodact->prodact_name }}</h4>
                                        <p class="mb-2"><span class="text-dark medium">Size: {{ $order_product->rel_to_size->size_name }}</span>, <span class="text-dark medium">Color: {{ $order_product->rel_to_color->color_name }}</span></p>
                                        <h4 class="fs-sm ft-bold mb-0 lh-1">TK {{ number_format($order_product->price) }} X {{ $order_product->quantity }}</h4>
                                    </div>
                                </div>
                            </div>

                        </div>
                        @php
                            $total += $order_product->price*$order_product->quantity;
                        @endphp
                        @endforeach

                    </div>
                    <div class="ord_list_footer d-flex align-items-center justify-content-between br-top px-3">
                        <div class="col-xl-12 col-lg-12 col-md-12 pl-0 py-2 olf_flex d-flex align-items-center justify-content-between">
                            <div class="olf_flex_inner">
                                <p class="m-0 p-0"><span class="text-muted medium text-left">Order Date: {{ $order->created_at->format('d-m-Y') }}</span></p>
                            </div>
                            <div class="olf_flex_inner">
                                <p class="m-0 p-0"><span class="text-muted medium text-left">Discount: {{ number_format($order->discount) }}</span></p>
                            </div>
                            <div class="olf_flex_inner">
                                <p class="m-0 p-0"><span class="text-muted medium text-left">Charge: {{ $order->charge }}</span></p>
                            </div>
                            <div class="olf_inner_right"><h5 class="mb-0 fs-sm ft-bold">Total: TK {{ number_format(($total-$order->discount)+$order->charge) }}</h5></div>
                        </div>
                    </div>
                </div>
                <!-- End Order List -->
                @endforeach
            </div>

        </div>
    </div>
</section>
<!-- ======================= Dashboard Detail End ======================== -->

@endsection
