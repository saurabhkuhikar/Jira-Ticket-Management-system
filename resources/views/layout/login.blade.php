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
        <div class="wrapper">
        <!-- nav bar start-->
        <!-- nabr end -->
        <!-- side bar  -->
        <!-- header of page -->
        <!-- start of content -->
        @yield('content')
        <!-- footer of page -->
    </div>
        <!-- end of content -->
    </body>
        <!-- page specific scripts -->
            @yield('pagespecificscripts')
    <!--end::Body-->
</html>
