<!DOCTYPE html>
<html lang="en">
    <!--begin::Head-->
        <head>
            <!--begin::Page Custom Styles(used by this page)-->
            @include('include.commonHead')
            @include('include.commonJs')
            <!--end::Page Custom Styles-->
        </head>
    <!--end::Head-->
    <!--begin::Body-->
    <body>
        <!-- start of content -->
        @yield('content')
        <!-- footer of page -->
        <!-- end of content -->
    </body>
        <!-- page specific scripts -->
            @yield('pagespecificscripts')
    <!--end::Body-->
</html>
