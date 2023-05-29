<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.shared/title-meta', ['title' => $page_title])

    @include('layouts.shared/head-css', ["mode" => $mode ?? '', "demo" => $demo ?? ''])

</head>


<body class="loading" data-layout='{"mode": "{{$theme ?? "light" }}", "width": "fluid", "menuPosition": "fixed", "sidebar": { "color": "{{$theme ?? "light" }}", "size": "default", "showuser": false}, "topbar": {"color": "dark"}, "showRightSidebarOnPageLoad": true}' @yield('body-extra')>
    <!-- Begin page -->
    <div id="wrapper">
        @include('layouts.shared/topbar')

        @if(Auth::user()->status == 0)<!--用戶是否啟用-->
            @if(Auth::user()->level == 0 || Auth::user()->id == 2)
                @include('layouts.shared/left-sidebar')
            @elseif(Auth::user()->level == 1 && Auth::user()->jod_id == 2)
            {{-- @elseif(Auth::user()->level == 1 && Auth::user()->jod_id == 2) --}}
            @else
                @include('layouts.shared/user-left-sidebar')
            @endif
        @endif

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">
                @yield('content')
            </div>
            <!-- content -->

            @include('layouts.shared/footer')

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->

    @include('layouts.shared/right-sidebar')

    @include('layouts.shared/footer-script')

</body>

</html>