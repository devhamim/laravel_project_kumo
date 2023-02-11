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
                        <li class="breadcrumb-item"><a href="#">Library</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Data</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- ======================= Top Breadcrubms ======================== -->

<!-- ======================= Product Detail ======================== -->
<section class="middle">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-xl-5 col-lg-6 col-md-12 col-sm-12">
                <div class="quick_view_slide">
                    @foreach ($thumbnails as $thum)
                    <div class="single_view_slide">
                        <a href="{{ asset('uplodes/prodact/thumbnail') }}/{{ $thum->thumbnail }}" data-lightbox="roadtrip" class="d-block mb-4">
                            <img src="{{ asset('uplodes/prodact/thumbnail') }}/{{ $thum->thumbnail }}" class="img-fluid rounded" alt="" />
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="col-xl-7 col-lg-6 col-md-12 col-sm-12">
                <div class="prd_details pl-3">

                    <div class="prt_01 mb-1">
                        <span class="text-light bg-info rounded px-2 py-1">
                            {{ App\Models\catagory::where('id', $product_info->first()->catagory_id)->first()->catagory_name }}
                        </span>
                    </div>
                <div class="br_code">
                    <div class="prt_02 mb-3 ">
                        <h2 class="ft-bold mb-1">{{ $product_info->first()->prodact_name }}</h2>
                        <div class="text-left">
                            @php
                                $rating = 0;

                                if ($total_review != 0) {
                                    $rating = round($total_star/$total_review);
                                }
                            @endphp
                            <div class="star-rating align-items-center d-flex justify-content-left mb-1 p-0">
                                @for($i = 1; $i <= $rating; $i++)
                                    <i class="fas fa-star filled"></i>
                                @endfor
                                @for($i = $rating + 1; $i <= 5; $i++)
                                    <i class="fas fa-star"></i>
                                @endfor
                                <span class="small">({{ $total_review }} Reviews)</span>
                            </div>
                            <div class="elis_rty">
                                @if($product_info->first()->discount != null)

                                <span class="ft-medium text-muted line-through fs-md mr-2">
                                    BDT {{ number_format($product_info->first()->price) }}
                                </span>
                                @endif
                                <span class="ft-bold theme-cl fs-lg mr-2">
                                    BDT {{ number_format($product_info->first()->after_discount) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class=" brcode_main">
                        {!! DNS2D::getBarcodeHTML($product_info->first()->prodact_name .' - '. $product_info->first()->after_discount, 'QRCODE' ,3,3) !!}
                    </div>
                </div>
                    <div class="prt_03 mb-4">
                        <p>{{ $product_info->first()->sort_desp }}</p>
                    </div>

                <form action="{{ route('add.cart') }}" method="POST">
                @csrf
                    <div class="prt_04 mb-2">
                        <p class="d-flex align-items-center mb-0 text-dark ft-medium">Color:</p>
                        <div class="text-left">
                            @php
                                $color = null;
                            @endphp
                            @foreach ($available_color as $color)
                                @if($color->rel_to_color->color_code != null)
                                    <div class="form-check form-option form-check-inline mb-1">
                                        <input class="form-check-input color_id" type="radio" name="color_id" id="white{{ $color->rel_to_color->id }}" value="{{ $color->color_id }}">
                                        <label class="form-option-label rounded-circle" for="white{{ $color->rel_to_color->id }}"><span class="form-option-color rounded-circle" style="background-color: #{{ $color->rel_to_color->color_code }}"></span></label>
                                    </div>
                                @else
                                    <strong class="text-danger">Not Available</strong>
                                    <input type="hidden" value="1" name="color_id">
                                @endif

                                @php
                                    $color = $color->rel_to_color->color_code;
                                @endphp
                            @endforeach
                        </div>
                        @error('color_id')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>

                    <div class="prt_04 mb-4">
                        <p class="d-flex align-items-center mb-0 text-dark ft-medium">Size:</p>
                        <div class="text-left pb-0 pt-2" id="size_id">
                            @if($color != null)
                            @foreach ($sizes as $size)
                                <div class="form-check size-option form-option form-check-inline mb-2" >
                                    <input class="form-check-input" type="radio" name="size_id" id="28">
                                    <label class="form-option-label" for="28">{{ $size->size_name }}</label>
                                </div>
                            @endforeach
                            @else
                            @foreach (App\Models\inventory::where('prodact_id', $product_info->first()->id)->get() as $size)
                                <div class="form-check size-option form-option form-check-inline mb-2" >
                                    <input type="hidden" value="1" name="size_id">

                                    <input class="form-check-input" type="radio" name="size_id" id="{{ $size->id }}" value="{{ $size->rel_to_size->id }}">
                                    <label class="form-option-label" for="{{ $size->id }}">{{ $size->rel_to_size->size_name }}</label>
                                </div>
                            @endforeach
                            @endif

                        </div>
                        @error('size_id')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>

                    <div class="prt_05 mb-4">
                        <div class="form-row mb-7">
                            <div class="col-12 col-lg-auto">
                                <!-- Quantity -->
                                <select class="mb-2 custom-select" name="quantity">
                                <option value="1" selected="">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                </select>
                            </div>
                            @error('quantity')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                            <div class="col-12 col-lg">
                                <input type="hidden" name="prodact_id" value="{{ $product_info->first()->id }}">
                                <!-- Submit -->
                                <button type="submit" class="btn btn-block custom-height bg-dark mb-2">
                                    <i class="lni lni-shopping-basket mr-2"></i>Add to Cart
                                </button>
                            </div>
                    </form>
                    <form action="{{ route('add.wish') }}" method="POST">
                        @csrf
                        <div class="col-12 col-lg-auto">
                            <input type="hidden" name="prodact_id" value="{{ $product_info->first()->id }}">
                            <!-- Wishlist -->
                            <button type="submit" class="btn custom-height btn-default mb-2 text-dark" >
                                <i class="lni lni-heart mr-2"></i>Wishlist
                            </button>
                        </div>
                    </form>
                    </div>
                    @if(session('stock'))
                        <strong class="text-danger">{{ session('stock') }}</strong>
                    @endif
                    </div>


                    <div class="prt_06">
                        <p class="mb-0 d-flex align-items-center">
                        <span class="mr-4">Share:</span>
                        <a class="d-inline-flex align-items-center justify-content-center p-3 gray circle fs-sm text-muted mr-2" href="#!">
                            <i class="fab fa-twitter position-absolute"></i>
                        </a>
                        <a class="d-inline-flex align-items-center justify-content-center p-3 gray circle fs-sm text-muted mr-2" href="#!">
                            <i class="fab fa-facebook-f position-absolute"></i>
                        </a>
                        <a class="d-inline-flex align-items-center justify-content-center p-3 gray circle fs-sm text-muted" href="#!">
                            <i class="fab fa-pinterest-p position-absolute"></i>
                        </a>
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
<!-- ======================= Product Detail End ======================== -->

<!-- ======================= Product Description ======================= -->
<section class="middle">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-xl-11 col-lg-12 col-md-12 col-sm-12">
                <ul class="nav nav-tabs b-0 d-flex align-items-center justify-content-center simple_tab_links mb-4" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="description-tab" href="#description" data-toggle="tab" role="tab" aria-controls="description" aria-selected="true">Description</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" href="#information" id="information-tab" data-toggle="tab" role="tab" aria-controls="information" aria-selected="false">Additional information</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" href="#reviews" id="reviews-tab" data-toggle="tab" role="tab" aria-controls="reviews" aria-selected="false">Reviews</a>
                    </li>
                </ul>

                <div class="tab-content" id="myTabContent">

                    <!-- Description Content -->
                    <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                        <div class="description_info">
                            <p> {!! $product_info->first()->long_desp !!}</p>
                        </div>
                    </div>

                    <!-- Additional Content -->
                    <div class="tab-pane fade" id="information" role="tabpanel" aria-labelledby="information-tab">
                        <div class="additionals">
                            <table class="table">
                                <tbody>
                                    <tr>
                                    <th class="ft-medium text-dark">ID</th>
                                    <td>#1253458</td>
                                    </tr>
                                    <tr>
                                    <th class="ft-medium text-dark">SKU</th>
                                    <td>KUM125896</td>
                                    </tr>
                                    <tr>
                                    <th class="ft-medium text-dark">Color</th>
                                    <td>Sky Blue</td>
                                    </tr>
                                    <tr>
                                    <th class="ft-medium text-dark">Size</th>
                                    <td>Xl, 42</td>
                                    </tr>
                                    <tr>
                                    <th class="ft-medium text-dark">Weight</th>
                                    <td>450 Gr</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Reviews Content -->
                    <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                        <div class="reviews_info">
                            @foreach ($reviews as $review)
                            <div class="">
                                <div class="single_rev_thumb"><img src="assets/img/team-1.jpg" class="img-fluid circle" width="90" alt="" /></div>
                                <div class="single_rev_caption d-flex justify-content-between align-items-start pl-3">
                                    <div class="single_capt_left">
                                        <h5 class="mb-0 fs-md ft-medium lh-1">{{ $review->rel_to_customer->name }}</h5>
                                        <span class="small">{{ $review->updated_at->format('d-M-Y') }}</span>
                                        <p>{{ $review->review }}</p>
                                    </div>
                                    <div class="">
                                        <div class="star-rating align-items-center d-flex justify-content-end mb-1 p-0">
                                            @for($i = 1; $i <=$review->star ; $i++)
                                                <i class="fas fa-star filled"></i>
                                            @endfor
                                            @for($x = $review->star + 1; $x <=5 ; $x++)
                                                <i class="fas fa-star"></i>
                                            @endfor

                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        @auth('customerlogin')
                            @if(App\Models\orderproduct::where('customer_id', Auth::guard('customerlogin')->id())->where('prodact_id', $product_info->first()->id)->exists())
                                @if(App\Models\orderproduct::where('customer_id', Auth::guard('customerlogin')->id())->where('prodact_id', $product_info->first()->id)->where('review', '!=', null)->first() == false)
                                    <div class="reviews_rate">
                                        <form class="row" action="{{ route('review.store') }}" method="POST">
                                            @csrf
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                                <h4>Submit Rating</h4>
                                            </div>

                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                                <div class="revie_stars d-flex align-items-center justify-content-between px-2 py-2 gray rounded mb-2 mt-1">
                                                    <div class="srt_013">
                                                        <div class="submit-rating">
                                                        <input id="star-5" type="radio" name="star" value="5" />
                                                        <label for="star-5" title="5 stars">
                                                            <i class="active fa fa-star" aria-hidden="true"></i>
                                                        </label>
                                                        <input id="star-4" type="radio" name="star" value="4" />
                                                        <label for="star-4" title="4 stars">
                                                            <i class="active fa fa-star" aria-hidden="true"></i>
                                                        </label>
                                                        <input id="star-3" type="radio" name="star" value="3" />
                                                        <label for="star-3" title="3 stars">
                                                            <i class="active fa fa-star" aria-hidden="true"></i>
                                                        </label>
                                                        <input id="star-2" type="radio" name="star" value="2" />
                                                        <label for="star-2" title="2 stars">
                                                            <i class="active fa fa-star" aria-hidden="true"></i>
                                                        </label>
                                                        <input id="star-1" type="radio" name="star" value="1" />
                                                        <label for="star-1" title="1 star">
                                                            <i class="active fa fa-star" aria-hidden="true"></i>
                                                        </label>
                                                        </div>
                                                    </div>

                                                    <div class="srt_014">
                                                        <h6 class="mb-0">4 Star</h6>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="medium text-dark ft-medium">Full Name</label>
                                                    <input type="text" class="form-control" name="customer_name" readonly value="{{ Auth::guard('customerlogin')->user()->name }}" />
                                                </div>
                                            </div>

                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="medium text-dark ft-medium">Email Address</label>
                                                    <input type="email" class="form-control" name="customer_email" value="{{ Auth::guard('customerlogin')->user()->email }}" />
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                                <div class="form-group">
                                                    <input type="hidden" name="prodact_id" value="{{ $product_info->first()->id }}">
                                                    <input type="hidden" name="customer_id" value="{{ Auth::guard('customerlogin')->id() }}">
                                                    <label class="medium text-dark ft-medium">Description</label>
                                                    <textarea class="form-control" name="review"></textarea>
                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                                <div class="form-group m-0">
                                                    <button type="submit" class="btn btn-white stretched-link hover-black">Submit Review <i class="lni lni-arrow-right"></i></button>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                @else
                                    <div class="alert alert-success">You already review this producr</div>
                                @endif

                            @else
                                <div class="alert alert-info">Please Buye Our Product</div>
                            @endif
                        @else
                            <div class="alert alert-danger">Please login For Review <a class="float-right py-2 px-4 bg-danger text-white" href="{{ route('customer.reglogin') }}">Login</a></div>
                        @endauth


                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ======================= Product Description End ==================== -->

<!-- ======================= Similar Products Start ============================ -->
<section class="middle pt-0">
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="sec_title position-relative text-center">
                    <h2 class="off_title">Similar Products</h2>
                    <h3 class="ft-bold pt-3">Matching Producta</h3>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="slide_items">

                    <!-- single Item -->
                    @foreach ($similer_product as $similer)
                        <div class="single_itesm">
                            <div class="product_grid card b-0 mb-0">
                                @if($similer->discount != null)
                                    <div class="badge bg-success text-white position-absolute ft-regular ab-left text-upper">Sale</div>
                                @endif
                                <div class="card-body p-0">
                                    <div class="shop_thumb position-relative">
                                        <a class="card-img-top d-block overflow-hidden" href="{{ route('details', $similer->slug) }}"><img class="card-img-top" src="{{ asset('uplodes/prodact/preview') }}/{{ $similer->preview }}" alt="..."></a>
                                    </div>
                                </div>
                                <div class="card-footer b-0 p-3 pb-0 d-flex align-items-start justify-content-center">
                                    <div class="text-left">
                                        <div class="text-center">
                                            <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1"><a href="{{ route('details', $similer->slug) }}">{{ $similer->prodact_name }}</a></h5>
                                            <div class="elis_rty"><span class="ft-bold fs-md text-dark">TK {{ number_format($similer->price) }}</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</section>
<!-- ======================= Similar Products Start ============================ -->

@endsection

@section('footer_script')
    <script>
        $('.color_id').click(function(){
            var color_id = $(this).val();
            var prodact_id = '{{  $product_info->first()->id }}';

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type:'POST',
                url:'/getsize',
                data:{'color_id':color_id, 'prodact_id':prodact_id},
                success:function(data){
                    $('#size_id').html(data);
                }
            });
        });
    </script>

	@if(session('success'))
		<script>
			const Toast = Swal.mixin({
            toast: true,
            position: 'top-center',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
            })

            Toast.fire({
            icon: 'success',
            title: '{{ session('success') }}'
            })
		</script>
	@endif
	@if(session('wish_login'))
		<script>
			const Toast = Swal.mixin({
            toast: true,
            position: 'top-center',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
            })

            Toast.fire({
            icon: 'success',
            title: '{{ session('success') }}'
            })
		</script>
	@endif
@endsection
