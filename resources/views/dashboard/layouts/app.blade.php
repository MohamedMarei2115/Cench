<!DOCTYPE html>
<html lang="en" id="demo" >

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="description" content="Cench">
    <meta name="author" content="Cench">
    <meta name="keywords"
          content="Cench">

    <!-- Favicon -->
    <link rel="icon" href="{{asset('/build/assets/img/brand/favicon.ico')}}" type="image/x-icon"/>

    <!-- Title -->
    <title>Cench</title>

    <!-- Bootstrap css-->
    <link id="style" href="{{asset('/build/assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet"/>

    <!-- Icons css-->
    <link href="{{asset('/build/assets/plugins/web-fonts/icons.css')}}" rel="stylesheet"/>
    <link href="{{asset('/build/assets/plugins/web-fonts/font-awesome/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('/build/assets/plugins/web-fonts/plugin.css')}}" rel="stylesheet"/>

    <!-- Style css-->
    <link href="{{asset('/build/assets/css/style.css')}}" rel="stylesheet">

    <!-- Select2 css-->
    <link href="{{asset('build/assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">

    <!-- Mutipleselect css-->
    <link rel="stylesheet" href="{{asset('/build/assets/plugins/multipleselect/multiple-select.css')}}">
    @yield('style')

</head>

<body class="ltr main-body leftmenu">

<!-- Loader -->
<div id="global-loader">
    <img src="{{asset('/build/assets/img/loader.svg')}}" class="loader-img" alt="Loader">
</div>
<!-- End Loader -->


<!-- Page -->
<div class="page">
    <!-- Main Header-->
    <div class="main-header side-header sticky">
        <div class="main-container container-fluid">
            <div class="main-header-left">
                <a class="main-header-menu-icon" href="javascript:void(0)" id="mainSidebarToggle"><span></span></a>
                <div class="hor-logo">
                    <a class="main-logo" href="index.html">
                        <img src="../assets/img/brand/logo.png" class="header-brand-img desktop-logo" alt="logo">
                        <img src="../assets/img/brand/logo-light.png" class="header-brand-img desktop-logo-dark"
                             alt="logo">
                    </a>
                </div>
            </div>
            <div class="main-header-center">
                <div class="responsive-logo">
                    <a href="index.html"><img src="../assets/img/brand/logo.png" class="mobile-logo" alt="logo"></a>
                    <a href="index.html"><img src="../assets/img/brand/logo-light.png" class="mobile-logo-dark"
                                              alt="logo"></a>
                </div>
            </div>
            <div class="main-header-right">
                <button class="navbar-toggler navresponsive-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent-4" aria-controls="navbarSupportedContent-4"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fe fe-more-vertical header-icons navbar-toggler-icon"></i>
                </button>
                <!-- Navresponsive closed -->
                <div
                    class="navbar navbar-expand-lg  nav nav-item  navbar-nav-right responsive-navbar navbar-dark  ">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
                        <div class="d-flex order-lg-2 ms-auto">
                            <div class="dropdown d-flex main-header-theme">
                                <a class="nav-link icon layout-setting">
										<span class="dark-layout">
											<i class="fe fe-sun header-icons"></i>
										</span>
                                    <span class="light-layout">
											<i class="fe fe-moon header-icons"></i>
										</span>
                                </a>
                            </div>
                            <!-- Theme-Layout -->
                            <!-- Full screen -->
                            <div class="dropdown ">
                                <a class="nav-link icon full-screen-link">
                                    <i class="fe fe-maximize fullscreen-button fullscreen header-icons"></i>
                                    <i class="fe fe-minimize fullscreen-button exit-fullscreen header-icons"></i>
                                </a>
                            </div>
                            <!-- Full screen -->
                            <!-- Profile -->
                            <div class="dropdown main-profile-menu">
                                <a class="d-flex" href="javascript:void(0)">
                                    <span class="main-img-user"><img alt="avatar"
                                                                     src="{{asset('build/assets/img/brand/raaq.png1')}}"></span>
                                </a>
                                <div class="dropdown-menu">
                                    <div class="header-navheading">
                                        <h6 class="main-notification-title">{{auth()->user()->username}}</h6>
                                        <p class="main-notification-text">{{auth()->user()->email}}</p>
                                    </div>
                                    <a class="dropdown-item border-top" href="{{route('profile')}}">
                                        <i class="fe fe-user"></i> My Profile
                                    </a>

                                    <a class="dropdown-item" href="{{route('logout')}}">
                                        <i class="fe fe-power"></i> Sign Out
                                    </a>
                                </div>
                            </div>
                            <!-- Profile -->
                            <!-- Sidebar -->
                            <div class="dropdown  header-settings">
                                <a href="javascript:void(0)" class="nav-link icon" data-bs-toggle="sidebar-right"
                                   data-bs-target=".sidebar-right">
                                    <i class="fe fe-align-right header-icons"></i>
                                </a>
                            </div>
                            <!-- Sidebar -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Main Header-->

    <!-- Sidemenu -->
    <div class="sticky">
        <div class="main-menu main-sidebar main-sidebar-sticky side-menu">
            <div class="main-sidebar-header main-container-1 active">
                <div class="sidemenu-logo">
                    <a class="main-logo" href="#">
                        <img src="{{asset('build/assets/img/brand/raaq.png1')}}" class="header-brand-img desktop-logo" style="border-radius: 50%" width="150" height="150" alt="logo">
                        <img src="{{asset('build/assets/img/brand/raaq.png1')}}" class="header-brand-img icon-logo"
                             alt="logo">
                        <img src="{{asset('build/assets/img/brand/raaq.png1')}}" class="header-brand-img desktop-logo theme-logo"
                             alt="logo">
                        <img src="{{asset('build/assets/img/brand/raaq.png1')}}" class="header-brand-img icon-logo theme-logo"
                             alt="logo">
                    </a>
                </div>
                <br><br><br><br><br><br>
                <div class="main-sidebar-body main-body-1">
                    <div class="slide-left disabled" id="slide-left"><i class="fe fe-chevron-left"></i></div>
                    <ul class="menu-nav nav">
                        <li class="nav-header"><span class="nav-label">Control Panel</span></li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <span class="shape1"></span>
                                <span class="shape2"></span>
                                <i class="ti-home sidemenu-icon menu-icon "></i>
                                <span class="sidemenu-label">Control Panel</span>
                            </a>
                        </li>
                        @if(auth()->user()->role_id == '0')
                        <li class="nav-item">
                            <a class="nav-link with-sub" href="javascript:void(0)">
                                <span class="shape1"></span>
                                <span class="shape2"></span>
                                <i class="ti-write sidemenu-icon menu-icon "></i>
                                <span class="sidemenu-label">
										<span class="sidemenu-label2">Settings</span>
									</span>
                                <i class="angle fe fe-chevron-right"></i>
                            </a>
                            <ul class="nav-sub">
                                <li class="nav-sub-item"><a class="nav-sub-link" href="{{route('setting.category')}}">Categories</a></li>
                                <li class="nav-sub-item"><a class="nav-sub-link" href="{{route('setting.size')}}">Sizes</a></li>
                                <li class="nav-sub-item"><a class="nav-sub-link" href="{{route('setting.product')}}">Products</a></li>
                                <li class="nav-sub-item"><a class="nav-sub-link" href="{{route('setting.order')}}">Orders</a></li>
                                <li class="nav-sub-item"><a class="nav-sub-link" href="{{route('setting.stock')}}">Stock</a></li>
{{--                                <li class="nav-sub-item"><a class="nav-sub-link" href="{{route('setting.general')}}">General Setting</a></li>--}}
                            </ul>
                        </li>
                        @endif
{{--                        <li class="nav-item">--}}
{{--                            <a class="nav-link with-sub" href="javascript:void(0)">--}}
{{--                                <span class="shape1"></span>--}}
{{--                                <span class="shape2"></span>--}}
{{--                                <i class="ti-write sidemenu-icon menu-icon "></i>--}}
{{--                                <span class="sidemenu-label">--}}
{{--                        										<span class="sidemenu-label2">الشحنات</span>--}}
{{--                        									</span>--}}
{{--                                <i class="angle fe fe-chevron-right"></i>--}}
{{--                            </a>--}}
{{--                            <ul class="nav-sub">--}}
{{--                                <li class="nav-sub-item"><a class="nav-sub-link" href="{{route('setting.shipment')}}">الشحنات</a></li>--}}
{{--                            </ul>--}}
{{--                        </li>--}}
                    </ul>
                    <div class="slide-right" id="slide-right"><i class="fe fe-chevron-right"></i></div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Sidemenu -->
    <div class="main-content side-content pt-0">

        <div class="main-container container-fluid">
            <div class="inner-body">

                @yield('content')

            </div>
        </div>
    </div>
    <!-- Main Content-->

<!-- End Main Content-->


    <!-- Main Footer-->
    <div class="main-footer text-center">
        <div class="container">
            <div class="row row-sm">
                <div class="col-md-12">
                    <span>Copyright © 2024 <a href="#">Cench</a>. Coded by <a
                            href="https://www.linkedin.com/in/mohamed-marei-043000188/" target="_blank">Mohamed Marei</a>. Designed by <a
                            href="">Cench</a> All rights reserved.</span>
                </div>
            </div>
        </div>
    </div>
    <!--End Footer-->


</div>
<!-- End Page -->

<!-- Back-to-top -->
<a href="#top" id="back-to-top"><i class="fe fe-arrow-up"></i></a>

<!-- Jquery js-->
<script src="{{asset('/build/assets/plugins/jquery/jquery.min.js')}}"></script>

<!-- Bootstrap js-->
<script src="{{asset('/build/assets/plugins/bootstrap/js/popper.min.js')}}"></script>
<script src="{{asset('/build/assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>

<!-- Internal Chart.Bundle js-->
<script src="{{asset('/build/assets/plugins/chart.js/Chart.bundle.min.js')}}"></script>

<!-- Peity js-->
<script src="{{asset('/build/assets/plugins/peity/jquery.peity.min.js')}}"></script>

<!-- Select2 js-->
<script src="{{asset('/build/assets/plugins/select2/js/select2.min.js')}}"></script>
<script src="{{asset('/build/assets/js/select2.js')}}"></script>

<!-- Perfect-scrollbar js -->
<script src="{{asset('/build/assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>

<!-- Sidemenu js -->
<script src="{{asset('/build/assets/plugins/sidemenu/sidemenu.js')}}"></script>

<!-- Sidebar js -->
<script src="{{asset('/build/assets/plugins/sidebar/sidebar.js')}}"></script>

<!-- Internal Morris js -->
<script src="{{asset('/build/assets/plugins/raphael/raphael.min.js')}}"></script>
<script src="{{asset('/build/assets/plugins/morris.js/morris.min.js')}}"></script>

<!-- Circle Progress js-->
<script src="{{asset('/build/assets/js/circle-progress.min.js')}}"></script>
<script src="{{asset('/build/assets/js/chart-circle.js')}}"></script>

<!-- Internal Dashboard js-->
<script src="{{asset('/build/assets/js/index.js')}}"></script>

<!-- Color Theme js -->
<script src="{{asset('/build/assets/js/themeColors.js')}}"></script>

<!-- Sticky js -->
<script src="{{asset('/build/assets/js/sticky.js')}}"></script>

<!-- Custom js -->
<script src="{{asset('/build/assets/js/custom.js')}}"></script>



<!-- Internal Data Table js -->
<script src="{{asset('/build/assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/build/assets/plugins/datatable/js/dataTables.bootstrap5.js')}}"></script>
<script src="{{asset('/build/assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('/build/assets/plugins/datatable/js/buttons.bootstrap5.min.js')}}"></script>
<script src="{{asset('/build/assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{asset('/build/assets/plugins/datatable/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('/build/assets/plugins/datatable/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('/build/assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{asset('/build/assets/plugins/select2/js/select2.min.js')}}"></script>
<script src="{{asset('/build/assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{asset('/build/assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('/build/assets/plugins/datatable/responsive.bootstrap5.min.js')}}"></script>
<script src="{{asset('/build/assets/js/table-data.js')}}"></script>
<script src="{{asset('/build/assets/js/select2.js')}}"></script>

@yield('script')
</body>

</html>
