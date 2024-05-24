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
        @if (session()->exists('notif'))
            @if (session()->get('notif')['success'])
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
                    <div class="panel-heading">Absensi Pegawai
                        ({{ Carbon\Carbon::now('Asia/Jakarta')->format('d F Y') }})</div>
                    <form action="{{ url('/absensi') }}" method="post">
                        {{ csrf_field() }}
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table id="absensi" class="table table-bordred table-striped">
                                    <thead>
                                        <tr>
                                            <th width="3%" class="text-center">No</th>
                                            @if ($keterangan === 'guru')
                                                <th width="30%">NIP</th>
                                            @endif
                                            <th width="35%">Nama Pegawai</th>
                                            <th width="32%">Kehadiran</th>
                                        </tr>
                                    </thead>
                                    <tbody id="isi">
                                        @foreach ($pegawai as $index => $pegawai)
                                            @php
                                                // Mengecek apakah pegawai sudah memiliki presensi hari ini
                                                $sudahAbsen = $presensiHariIni->contains($pegawai->id_pegawai);
                                            @endphp
                                            <tr>
                                                <input type="hidden" name="pegawai[]" value="{{ $pegawai->id_pegawai }}">
                                                <td class="text-center">{{ $index + 1 }}</td>
                                                @if ($keterangan === 'guru')
                                                    <td>{{ $pegawai->NIP }}</td>
                                                @endif
                                                <td>{{ $pegawai->Nama }}</td>
                                                <td>
                                                    @if ($sudahAbsen)
                                                        <!-- Jika sudah absen, tampilkan pesan atau sembunyikan form input kehadiran -->
                                                        <p>Sudah absen</p>
                                                    @else
                                                        <!-- Jika belum absen, tampilkan form input kehadiran -->
                                                        <label class="radio-inline">
                                                            <input id="hadir" type="radio"
                                                                name="keterangan[{{ $pegawai->id_pegawai }}]" value="Hadir"
                                                                checked>Hadir
                                                        </label>
                                                        <label class="radio-inline">
                                                            <input id="sakit" type="radio"
                                                                name="keterangan[{{ $pegawai->id_pegawai }}]"
                                                                value="Sakit">Sakit
                                                        </label>
                                                        <label class="radio-inline">
                                                            <input id="izin" type="radio"
                                                                name="keterangan[{{ $pegawai->id_pegawai }}]"
                                                                value="Izin">Izin
                                                        </label>
                                                        <label class="radio-inline">
                                                            <input id="alpa" type="radio"
                                                                name="keterangan[{{ $pegawai->id_pegawai }}]"
                                                                value="Tanpa keterangan">Alpa
                                                        </label>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <p data-placement="top" data-toggle="tooltip" title="Add" class="pull-right"
                            style="margin-top: 5px;">
                            <button class="btn btn-primary btn-sm" type="submit" data-title="Add">Submit</button>
                        </p>
                    </form>
                </div>
                <div class="col-sm-12">
                    <p class="back-link">&copy; {{ date('Y') }} SDN 88 Bengkulu Tengah</p>
                </div>
            </div><!--/.row-->
        </div>
    </div>
    </div>
@endsection
