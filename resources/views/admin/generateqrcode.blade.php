@extends('layouts.master')
@section('title', 'Generate QR Code')
@section('content')
    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="#">
                        <em class="fa fa-home"></em>
                    </a></li>
                <li class="active">Admin</li>
                <li class="active">Generate QR Code</li>
            </ol>
        </div><!--/.row-->
        
        @if (session()->has('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">Generate QR Code</div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>QR Code</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pegawais as $index => $pegawai)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $pegawai->Nama }}</td>
                                            <td>{!! QrCode::size(100)->generate($pegawai->id_pegawai) !!}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <a href="{{ route('download.qrcode') }}" class="btn btn-primary">Download All QR Codes</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
