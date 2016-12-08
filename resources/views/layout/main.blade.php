<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('siakad.title') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- intercooler data previx is a must -->
    <meta name="intercoolerjs:use-data-prefix" content="true"/>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/btable/bootstrap-table.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    {{--<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">--}}
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('lte/css/AdminLTE.min.css') }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('lte/css/skins/_all-skins.min.css') }}">
    <link rel="stylesheet" href="{{ asset('TSSTMIK.css') }}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
    @include("layout.header")
    <!-- =============================================== -->
    @include('layout.menu')
    <!-- =============================================== -->
    <!-- Content Wrapper. Contains page content -->
    <div id="the-content" class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            @yield('content-header')
        </section>

        <!-- Main content -->
        <section class="content">
            @yield('content')
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    @include("layout.footer")
</div>
<!-- ./wrapper -->
{{-- Digunakan untuk yang ingin menggunakan modal --}}
<div class="modal fade"
     id="modal-util"
     {{--Bug karena field tidak dapat autofocus di dialog window bootstrap adalah tabindex="-1" di remove--}}
     {{--tabindex="-1" --}}
     role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 id="modal-util-title" class="modal-title">{{ config('siakad.nama') }}</h4>
            </div>
            <div id="modal-util-body" class="modal-body">Tunggu Sedang loading ...</div>
        </div>
    </div>
</div>
<!-- jQuery 2.2.0 -->
<script src="{{ asset('plugins/jQuery/jQuery-2.2.0.min.js') }}"></script>
<script src="{{ asset('plugins/intercooler/intercooler-1.0.3.min.js') }}"></script>
<!-- Bootstrap 3.3.5 -->
<script src="{{ asset('plugins/bootstrap/bootstrap.min.js') }}"></script>
<script src="{{ asset('plugins/btable/bootstrap-table.min.js') }}"></script>
<!-- SlimScroll -->
{{--<script src="{{ asset('plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>--}}
<!-- FastClick -->
{{--<script src="{{ asset('plugins/fastclick/fastclick.min.js') }}"></script>--}}
<!-- AdminLTE App -->
<script src="{{ asset('lte/js/app.js') }}"></script>
<script src="{{ asset('TSSTMIK.js') }}"></script>
@stack('late-script')
</body>
</html>
