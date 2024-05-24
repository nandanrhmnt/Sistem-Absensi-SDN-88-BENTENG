@extends('layouts.master')
@section('title', 'Dashboard')
@section('content')
    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="#">
                        <em class="fa fa-home"></em>
                    </a></li>
                <li class="active">Dashboard</li>
            </ol>
        </div><!--/.row-->

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>
                    <div class="panel-body">
                        <blockquote>
                            <p>Selamat Datang {{ Auth::user()->username }} !</p>
                        </blockquote>
                    </div>
                </div>
            </div>
        </div><!--/.row-->
        <div class="row">
            <div class="col-lg-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">Jumlah Pegawai</div>
                    <div class="panel-body">
                        <h1>{{ $pegawai_count }}</h1>
                        <p>Total pegawai di SDN 88 Bengkulu Tengah</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="panel panel-success">
                    <div class="panel-heading">Presensi Pegawai Hari Ini</div>
                    <div class="panel-body">
                        <h1>{{ $presensi_count }}</h1>
                        <p>Jumlah pegawai yang telah menscan QR code untuk absensi hari ini</p>
                    </div>
                </div>
            </div>
        </div><!--/.row-->

        <div class="col-sm-12">
            <p class="back-link">&copy; <?php echo date('Y'); ?> SDN 88 Bengkulu Tengah</p>
        </div>
    </div><!--/.row-->
    <!--/.main-->
@endsection
