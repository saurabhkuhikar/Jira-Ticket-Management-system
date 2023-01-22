<!DOCTYPE html>
<html lang="en">
    <!--begin::Head-->
        <head>
            <!--begin::Page Custom Styles(used by this page)-->
            @include('include.commonHead')
            @include('include.headFiles')
            @include('include.commonJs')
            <!--end::Page Custom Styles-->
        </head>
    <!--end::Head-->
    <!--begin::Body-->
    <body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
        <div class="wrapper">
        <!-- nav bar start-->
        @include('layout.navbar')
        <!-- nabr end -->
        <!-- side bar  -->
        @include('include.sidebar_admin')
        <!-- header of page -->
        <!-- start of content -->
        @yield('content')
        <!-- footer of page -->
        @include('include.admin_footer')
    </div>
        <!-- end of content -->
    </body>
        <!-- page specific scripts -->
            @yield('pagespecificscripts')
            @include('include.dashoboardJs')
    <!--end::Body-->
</html>
