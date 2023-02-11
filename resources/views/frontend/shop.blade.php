@extends('frontend.master')

@section('content')

<!-- ======================= Shop Style 1 ======================== -->
<section class="bg-cover" style="background:url({{ asset('uplodes/shop_banner') }}/{{ $shop_banner->first()->banner_img }}) no-repeat;">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="text-left py-5 mt-3 mb-3">
                    <h1 class="ft-medium mb-3">Shop</h1>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ======================= Shop Style 1 ======================== -->


<!-- ======================= Filter Wrap Style 1 ======================== -->
<section class="py-3 br-bottom br-top">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Shop</a></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- ============================= Filter Wrap ============================== -->


<!-- ======================= All Product List ======================== -->
<section class="middle">
    <div class="container">
        <div class="row">

            <div class="col-xl-3 col-lg-4 col-md-12 col-sm-12 p-xl-0">
                <div class="search-sidebar sm-sidebar border">
                    <div class="search-sidebar-body">
                        <!-- Single Option -->
                        <div class="single_search_boxed">
                            <div class="col-lg-12">
                                <div class="form-group px-3">
                                    <a href="{{ route('shop') }}" class="btn btn-danger form-control">Reset Filter</a>
                                </div>
                            </div>
                            <div class="widget-boxed-header">
                                <h4><a href="#pricing" data-toggle="collapse" aria-expanded="false" role="button">Pricing</a></h4>
                            </div>
                            <div class="widget-boxed-body collapse show" id="pricing" data-parent="#pricing">
                                <div class="row">
                                    <div class="col-lg-6 pr-1">
                                        <div class="form-group pl-3">
                                            <input type="number" class="form-control" id="min" name="min" placeholder="Min" value="{{ @$_GET['min'] }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 pl-1">
                                        <div class="form-group pr-3">
                                            <input type="number" class="form-control" id="max" name="max" placeholder="Max" value="{{ @$_GET['max'] }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group px-3" id="sort_price">
                                            <button type="submit" class="btn form-control">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

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
                                                    @foreach ($catagorys as $catagory)
                                                    <li>
                                                        <input id="category{{ $catagory->id }}" class="catagory_id" name="catagory_id" type="radio" value="{{ $catagory->id }}"
                                                        @if(isset($_GET['catagory_id']))
                                                            @if($_GET['catagory_id'] == $catagory->id)
                                                                checked
                                                            @endif
                                                        @endif
                                                        >
                                                        <label for="category{{ $catagory->id }}" class="checkbox-custom-label">{{ $catagory->catagory_name }}<span>{{ App\Models\prodact::where('catagory_id', $catagory->id)->count() }}</span></label>
                                                    </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Single Option -->
                        <div class="single_search_boxed">
                            <div class="widget-boxed-header">
                                <h4><a href="#brands" data-toggle="collapse" aria-expanded="false" role="button">Brands</a></h4>
                            </div>
                            {{-- <div class="widget-boxed-body collapse show" id="brands" data-parent="#brands">
                                <div class="side-list no-border">
                                    <!-- Single Filter Card -->
                                    <div class="single_filter_card">
                                        <div class="card-body pt-0">
                                            <div class="inner_widget_link">
                                                <ul class="no-ul-list">
                                                    <li>
                                                        <input id="brands1" class="checkbox-custom" name="brands" type="radio">
                                                        <label for="brands1" class="checkbox-custom-label">Sumsung<span>142</span></label>
                                                    </li>
                                                    <li>
                                                        <input id="brands2" class="checkbox-custom" name="brands" type="radio">
                                                        <label for="brands2" class="checkbox-custom-label">Apple<span>652</span></label>
                                                    </li>
                                                    <li>
                                                        <input id="brands3" class="checkbox-custom" name="brands" type="radio">
                                                        <label for="brands3" class="checkbox-custom-label">Nike<span>232</span></label>
                                                    </li>
                                                    <li>
                                                        <input id="brands4" class="checkbox-custom" name="brands" type="radio">
                                                        <label for="brands4" class="checkbox-custom-label">Reebok<span>192</span></label>
                                                    </li>
                                                    <li>
                                                        <input id="brands5" class="checkbox-custom" name="brands" type="radio">
                                                        <label for="brands5" class="checkbox-custom-label">Hawai<span>265</span></label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>

                        <!-- Single Option -->
                        <div class="single_search_boxed">
                            <div class="widget-boxed-header">
                                <h4><a href="#colors" data-toggle="collapse" class="collapsed" aria-expanded="false" role="button">Colors</a></h4>
                            </div>
                            <div class="widget-boxed-body collapse show" id="colors" data-parent="#colors">
                                <div class="side-list no-border">
                                    <!-- Single Filter Card -->
                                    <div class="single_filter_card">
                                        <div class="card-body pt-0">
                                            <div class="text-left">

                                                @foreach ($colors as $color)
                                                <div class="  form-check-inline mb-1">
                                                    <input name="color" class="color_idd" id="color{{$color->id}}" value="{{$color->id}}" type="radio"
                                                    @if (isset($_GET['color_id']))
                                                        @if ($_GET['color_id'] == $color->id)
                                                            checked
                                                        @endif
                                                    @endif
                                                    >
                                                    <label for="color{{$color->id}}">#{{$color->color_name}}</label>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Single Option -->
                        <div class="single_search_boxed">
                            <div class="widget-boxed-header">
                                <h4><a href="#size" data-toggle="collapse" class="collapsed" aria-expanded="false" role="button">Size</a></h4>
                            </div>
                            <div class="widget-boxed-body collapse show" id="size" data-parent="#size">
                                <div class="side-list no-border">
                                    <!-- Single Filter Card -->
                                    <div class="single_filter_card">
                                        <div class="card-body pt-0">
                                            <div class="text-left pb-0 pt-2">
                                                @foreach ($sizes as $size)
                                                <div class="form-check form-option form-check-inline mb-2">
                                                    <input name="size" class="size_idd" id="size{{$size->id}}" value="{{$size->id}}" type="radio"
                                                    @if (isset($_GET['size_id']))
                                                        @if ($_GET['size_id'] == $size->id)
                                                            checked
                                                        @endif
                                                    @endif
                                                    >
                                                    <label for="size{{$size->id}}">{{$size->size_name}}</label>
                                                </div>
                                                @endforeach
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

                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="border mb-3 mfliud">
                            <div class="row align-items-center py-2 m-0">
                                <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
                                    <h6 class="mb-0">Searched Products Found: {{ $products_count }}</h6>
                                </div>

                                <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12">
                                    <div class="filter_wraps d-flex align-items-center justify-content-end m-start">
                                        <div class="single_fitres mr-2 br-right">
                                            <select class="custom-select simple" id="sort" name="sort">
                                              <option value="">Default Sorting</option>
                                              <option {{ @$_GET['sort'] == 1?'selected':'' }} value="1">Sort by: A - Z</option>
                                              <option {{ @$_GET['sort'] == 2?'selected':'' }} value="2">Sort by: Z - A</option>
                                              <option {{ @$_GET['sort'] == 3?'selected':'' }} value="3">Sort by: Hight - Low price</option>
                                              <option {{ @$_GET['sort'] == 4?'selected':'' }} value="4">Sort by: Low - Hight price</option>
                                            </select>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- row -->
                <div class="row align-items-center rows-products">

                    <!-- Single -->
                    @forelse ($products as $product)
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
                    @empty
                    <div class="col-xl-12 col-lg-12 col-md-12 col-12 m-auto pt-5">
                        <h3 class="text-center text-danger">No product has been found</h3>
                    </div>
                    @endforelse
                </div>
                <div class="my-3">
                    {{ $products->links() }}
                </div>
                <!-- row -->
            </div>
        </div>
    </div>
</section>
<!-- ======================= All Product List ======================== -->

@endsection
