@extends('layouts.master')
@section('title', 'Presensi Pegawai')
@section('content')
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#"><em class="fa fa-home"></em></a></li>
            <li class="active">Admin</li>
            <li class="active">Presensi Pegawai</li>
        </ol>
    </div><!--/.row-->
    @if(session()->exists('notif'))
    @if(session()->get('notif')['success'])
    <div class="alert alert-success alert-dismissable"> 
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
        <strong>Sukses! </strong>{{ session()->get('notif')['msgaction'] }}
    </div>
    @else
    <div class="alert alert-danger alert-dismissable"> 
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
        <strong>Gagal! </strong>{{ session()->get('notif')['msgaction'] }}
    </div>
    @endif
    @endif
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">Daftar Pegawai</div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table id="pegawai" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="1%" class="text-center">No</th>
                                    <th width="30%">List Pegawai</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">1</td>
                                    <td>
                                        <a href="{{ url('/absensi/guru') }}">Guru</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">2</td>
                                    <td>
                                        <a href="{{ url('/absensi/honorer') }}">Honorer</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <p class="back-link">&copy; {{ date('Y') }} SDN 88 Bengkulu Tengah</p>
            </div>
        </div><!--/.row-->
    </div>
</div>
@endsection
