<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Gymove - Fitness Bootstrap Admin Dashboard</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/dashbord_asset/images/favicon.png') }}">
    <link href="{{ asset('/dashbord_asset/vendor/jqvmap/css/jqvmap.min.css') }}" rel="stylesheet">
	<link rel="stylesheet" href="{{ asset('/dashbord_asset/vendor/chartist/css/chartist.min.css') }}">
    <link href="{{ asset('/dashbord_asset/vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet">
	<link href="{{ asset('/dashbord_asset/vendor/owl-carousel/owl.carousel.css') }}" rel="stylesheet">
    <link href="{{ asset('/dashbord_asset/css/style.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
</head>
<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            <a href="{{ route('home') }}" class="brand-logo">
                <img class="logo-abbr" src="{{ asset('dashbord_asset/images/logo.png') }}" alt="">
                <img class="logo-compact" src="{{ asset('dashbord_asset/images/logo-text.png') }}" alt="">
                <img class="brand-title" src="{{ asset('dashbord_asset/images/logo-text.png') }}" alt="">
            </a>

            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->


		<!--**********************************
            Header start
        ***********************************-->
        <div class="header">
            <div class="header-content">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                        <div class="header-left">
                            <div class="dashboard_bar">
								Workout Statistic
                            </div>
                        </div>
                        <ul class="navbar-nav header-right">

                            <li class="nav-item dropdown header-profile">
                                <a class="nav-link" href="javascript:void(0)" role="button" data-toggle="dropdown">

                                    @if(Auth::user()->photo == null)
                                        <img src="{{ Avatar::create(Auth::user()->name)->toBase64(); }}" alt="">
                                    @else
                                        <img src="{{ asset('uplodes/profile/') }}/{{ Auth::user()->photo }}" width="20" alt=""/>
                                    @endif

									<div class="header-info">
										<span class="text-black"><strong>{{ Auth::user()->name }}</strong></span>
										<p class="fs-12 mb-0">{{ Auth::user()->email }}</p>
                                        @forelse (Auth::user()->roles as $role)
                                        <span class="fs-12 mt-2 bg-success p-1 text-center mx-2 rounded text-white">{{ $role->name }}</span>
                                        @empty
                                        <span class="fs-12 mt-2 p-1 text-center mx-2 rounded text-white bg-danger">Not Assigned</span>
                                        @endforelse
									</div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="{{ route('profile') }}" class="dropdown-item ai-icon">
                                        <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" class="text-primary" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                        <span class="ml-2">Profile </span>
                                    </a>
                                    <a href="./email-inbox.html" class="dropdown-item ai-icon">
                                        <svg id="icon-inbox" xmlns="http://www.w3.org/2000/svg" class="text-success" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                        <span class="ml-2">Inbox </span>
                                    </a>
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();" class="dropdown-item ai-icon">
                                        <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                                        <span class="ml-2">Logout </span>
                                    </a>
                                    <form id="logout-form" action="{{ route('user.logout') }}" method="GET" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
        <div class="deznav">
            <div class="deznav-scroll">

                @can('show_manu')
				<ul class="metismenu" id="menu">
                    <li><a class="" href=" {{ route('home') }}" aria-expanded="false">
							<i class="flaticon-381-networking"></i>
							<span class="nav-text">Dashboard</span>
						</a>

                    </li>
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="flaticon-381-television"></i>
							<span class="nav-text">User</span>
						</a>
                        <ul aria-expanded="false">
                            <li><a href="{{ route('user') }}">User list</a></li>
                            <li>
                                @can('profile_edit')
                                    <a href="{{ route('profile.edit') }}">Profile Edit</a>
                                @endcan
                            </li>
                        </ul>
                    </li>
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="flaticon-381-television"></i>
							<span class="nav-text">Catagory</span>
						</a>
                        <ul aria-expanded="false">
                            @can('show_catagory')
                            <li><a href="{{ route('catagory') }}">Catagory list</a></li>
                                @endcan
                            @can('category_trash')
                            <li><a href="{{ route('catagory.trash') }}">Catagory Trash</a></li>
                            @endcan
                        </ul>
                    </li>
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="flaticon-381-television"></i>
							<span class="nav-text">SubCatagory</span>
						</a>
                        <ul aria-expanded="false">
                            @can('show_subcategory')
                                <li><a href="{{ route('subcatagory') }}">SubCatagory list</a></li>
                            @endcan
                            @can('show_subcategory_trash')
                                <li><a href="{{ route('subcatagory.trash') }}">SubCatagory Trash</a></li>
                            @endcan
                        </ul>
                    </li>
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="flaticon-381-television"></i>
							<span class="nav-text">Prodact</span>
						</a>
                        <ul aria-expanded="false">
                            @can('add_product_')
                                <li><a href="{{ route('prodact') }}">Add Prodact</a></li>
                            @endcan
                                @can('show_product_list')
                                <li><a href="{{ route('prodact.list') }}">Prodact List</a></li>
                            @endcan
                            @can('product_variation')
                                <li><a href="{{ route('variation') }}">Prodact Variation</a></li>
                            @endcan
                        </ul>
                    </li>
                    @can('show_coupon')
                    <li>
                        <a class="has-arrow ai-icon" href="{{ route('coupon') }}" aria-expanded="false">
                            <i class="flaticon-381-television"></i>
                            <span class="nav-text">Coupon</span>
                        </a>
                    </li>
                    @endcan
                    @can('show_order')
                    <li>
                        <a class="has-arrow ai-icon" href="{{ route('order') }}" aria-expanded="false">
                            <i class="flaticon-381-television"></i>
                            <span class="nav-text">Order</span>
                        </a>
                    </li>
                    @endcan
                    @can('show_role')
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i class="flaticon-381-television"></i>
                        <span class="nav-text">Role</span>
                    </a>
                    <ul aria-expanded="false">
                        {{-- <li><a href="{{ route('show.permission') }}">Add Permission</a></li> --}}
                        <li><a href="{{ route('role') }}">Add Role</a></li>
                        <li><a href="{{ route('user.role') }}">User Role</a></li>
                    </ul>
                    </li>
                    @endcan
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i class="flaticon-381-television"></i>
                        <span class="nav-text">Add Banner</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{ route('add.banner') }}">Banner</a></li>
                            <li><a href="{{ route('shop.banner') }}">Shop Banner</a></li>
                        </ul>
                    </li>
                </ul>
                @endcan
				<div class="copyright">
					<p><strong>Gymove Fitness Admin Dashboard</strong> © 2020 All Rights Reserved</p>
					<p>Made with <span class="heart"></span> by DexignZone</p>
				</div>

			</div>
        </div>
        <!--**********************************
            Sidebar end
        ***********************************-->


		<!--**********************************
            Content body start
        ***********************************-->
        @can('Show_dashboard')
        <div class="content-body">
            <!-- row -->
			<div class="container-fluid">
                <main class="py-4">
                    @yield('content')
                </main>
            </div>
        </div>
        @endcan
        <!--**********************************
            Content body end
        ***********************************-->

        <!--**********************************
            Footer start
        ***********************************-->
        <div class="footer">
            <div class="copyright">
                <p>Copyright © Designed &amp; Developed by <a href="http://dexignzone.com/" target="_blank">DexignZone</a> 2020</p>
            </div>
        </div>
        <!--**********************************
            Footer end
        ***********************************-->

		<!--**********************************
           Support ticket button start
        ***********************************-->

        <!--**********************************
           Support ticket button end
        ***********************************-->


    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="{{ asset('dashbord_asset/vendor/global/global.min.js') }}"></script>
	<script src="{{ asset('dashbord_asset/vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
	<script src="{{ asset('dashbord_asset/vendor/chart.js/Chart.bundle.min.js') }}"></script>
    <script src="{{ asset('dashbord_asset/js/custom.min.js') }}"></script>
	<script src="{{ asset('dashbord_asset/js/deznav-init.js') }}"></script>


    {{-- summer note --}}
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

	<!-- Chart piety plugin files -->
    <script src="{{ asset('dashbord_asset/vendor/peity/jquery.peity.min.js') }}"></script>

	<!-- Apex Chart -->
	<script src="{{ asset('dashbord_asset/vendor/apexchart/apexchart.js') }}"></script>

	<!-- Dashboard 1 -->
	<script src="{{ asset('dashbord_asset/js/dashboard/workout-statistic.js') }}"></script>

    @yield('footer_scrip')
</body>
</html>
