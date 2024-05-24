<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="stylesheet" type="text/css" href="{!! asset('css/bootstrap.min.css') !!}">
    <link href="{!! asset('css/font-awesome.min.css') !!}" rel="stylesheet">
    <link href="{!! asset('css/datepicker3.css') !!}" rel="stylesheet">
    <link href="{!! asset('css/styles.css') !!}" rel="stylesheet">
    <link href="{!! asset('css/daterangepicker.css') !!}" rel="stylesheet">
    <link href="{!! asset('css/select2.min.css') !!}" rel="stylesheet">
    <link href="{!! asset('css/select2-bootstrap.css') !!}" rel="stylesheet">
    <style>
        .navbar-custom {
            background-color: #0d6efd;
        }
        .navbar-custom .navbar-brand, 
        .navbar-custom .navbar-nav > li > a {
            color: white;
        }
        .profile-sidebar {
            display: flex;
            align-items: center; /* Center vertically */
        }
        .profile-userpic img {
            width: 50px; /* Adjust size as needed */
            height: 50px;
            border-radius: 50%; /* Make it a circle */
        }
        .profile-usertitle {
            margin-left: 15px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse"><span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span></button>
                    <a class="navbar-brand" href="/">Absensi SDN 88 Bengkulu Tengah </a>
                </div>
            </div><!-- /.container-fluid -->
        </nav>
        <div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
            <div class="profile-sidebar">
                <div class="profile-userpic">
                    <img src="{!! asset('img/profil-icon.png') !!}" class="img-responsive" alt="">
                </div>
                <div class="profile-usertitle">
                    <div class="profile-usertitle-name">{{Auth::user()->username}}</div>
                </div>
                <div class="clear"></div>
            </div>
            <ul class="nav menu">
                <li><a href="/"><em class="fa fa-dashboard">&nbsp;</em> Dashboard</a></li>
                <li><a href="{{ url('/absensi/') }}"><em class="fa fa-calendar">&nbsp;</em> Presensi</a></li>
            @if(Auth::user()->akses=="Admin")
                <li><a href="{{ url('/admin/all') }}"><em class="fa fa-cogs">&nbsp;</em> Manajemen Data <span class="label label-info">{{ App\TbPegawai::all()->count() }}</span></a></li>
            @endif
                <li><a href="/admin/generate-qrcode"><em class="fa fa-qrcode">&nbsp;</em> Generate QR Code</a></li>
                <li><a href="{{ route('admin.show') }}"><em class="fa fa-print">&nbsp;</em> Generate Laporan</a></li>
                <li><a href="/logout"><em class="fa fa-power-off">&nbsp;</em> Logout</a></li>
            </ul>
            </div><!--/.sidebar-->
    @yield('content')
    <script src="{!! asset('js/jquery-3.2.1.min.js') !!}"></script>
    <script src="{!! asset('js/bootstrap.min.js') !!}"></script>
    <script src="{!! asset('js/bootstrap-datepicker.js') !!}"></script>
    <script src="{!! asset('js/chart-data.js') !!}"></script>
    <script src="{!! asset('js/easypiechart.js') !!}"></script>
    <script src="{!! asset('js/easypiechart-data.js') !!}"></script>
    <script src="{!! asset('js/custom.js') !!}"></script>
    <script src="{!! asset('js/checkall.js') !!}"></script>
    <script src="{!! asset('js/crud-ajax.js') !!}"></script>
    <script src="{!! asset('js/moment-local.min.js') !!}"></script>
    <script src="{!! asset('js/select2.min.js') !!}"></script>
    <script src="{!! asset('js/daterangepicker.js') !!}"></script>
    <script>
        $(document).ready(function() {
            $('select').select2();
        });
    </script>
    @yield('js')
</body>
</html>