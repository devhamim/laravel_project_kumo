@extends('frontend.master')

@section('content')
<!-- ======================= Filter Wrap Style 1 ======================== -->
<section class="py-3 br-bottom br-top">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Category By Product: <strong>{{ $catagory->catagory_name }}</strong></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- ============================= Filter Wrap ============================== -->

<section class="middle">
    <div class="container">
        <div class="row">

            <div class="col-xl-3 col-lg-4 col-md-12 col-sm-12 p-xl-0">
                <div class="search-sidebar sm-sidebar border">
                    <div class="search-sidebar-body">

                        <!-- Single Option -->
                        <div class="single_search_boxed">
                            <div class="widget-boxed-header">
                                <h4><a href="#Categories" data-toggle="collapse" aria-expanded="false" role="button">Categories</a></h4>
                            </div>
                            <div class="widget-boxed-body collapse show" id="Categories" data-parent="#Categories">
                                <div class="side-list no-border">
                                    <!-- Single Filter Card -->
                                    <div class="single_filter_card">
                                        <div class="card-body pt-0">
                                            <div class="inner_widget_link">
                                                <ul class="no-ul-list">
                                                    <li>
                                                        <input id="category1" class="checkbox-custom" name="category" type="radio">
                                                        <label for="category1" class="checkbox-custom-label">Accesorries<span>142</span></label>
                                                    </li>
                                                    <li>
                                                        <input id="category2" class="checkbox-custom" name="category" type="radio">
                                                        <label for="category2" class="checkbox-custom-label">Electronics<span>652</span></label>
                                                    </li>
                                                    <li>
                                                        <input id="category3" class="checkbox-custom" name="category" type="radio">
                                                        <label for="category3" class="checkbox-custom-label">Fashion<span>232</span></label>
                                                    </li>
                                                    <li>
                                                        <input id="category4" class="checkbox-custom" name="category" type="radio">
                                                        <label for="category4" class="checkbox-custom-label">Sports<span>192</span></label>
                                                    </li>
                                                    <li>
                                                        <input id="category5" class="checkbox-custom" name="category" type="radio">
                                                        <label for="category5" class="checkbox-custom-label">Home Appliances<span>265</span></label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-9 col-lg-8 col-md-12 col-sm-12">
                <!-- row -->
                <div class="row align-items-center rows-products">

                    <!-- Single -->
                    @foreach ($categoru_product as $product)
                    <div class="col-xl-4 col-lg-4 col-md-6 col-6">
                        <div class="product_grid card b-0">
                            <div class="badge bg-info text-white position-absolute ft-regular ab-left text-upper">New</div>
                            <div class="card-body p-0">
                                <div class="shop_thumb position-relative">
                                    <a class="card-img-top d-block overflow-hidden" href="{{ route('details', $product->slug) }}"><img class="card-img-top" src="{{ asset('uplodes/prodact/preview') }}/{{ $product->preview }}" alt="..."></a>
                                </div>
                            </div>
                            <div class="card-footer b-0 p-0 pt-2 bg-white">

                                <div class="text-left">
                                    <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1"><a href="{{ route('details', $product->slug) }}">{{ $product->prodact_name }}</a></h5>
                                    <div class="elis_rty my-2">
                                        @if($product->discount != null)
                                            <span class="text-muted line-through mr-2 ft-bold text-dark fs-sm">TK {{ number_format($product->price) }}</span>
                                        @endif
                                            <span class="ft-bold text-dark fs-sm">TK {{ number_format($product->after_discount) }}</span>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="my-3">
                    {{ $categoru_product->links() }}
                </div>
                <!-- row -->
            </div>
        </div>
    </div>
</section>
@endsection
