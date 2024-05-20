@extends('layouts.master')
@section('title', 'Web Presensi | Data Pegawai')
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
                    <div class="panel-heading">Absensi Pegawai {{ $keterangan }}
                    ({{ Carbon\Carbon::now('Asia/Jakarta')->format('d F Y') }})</div>
                <form action="/absensi" method="post">
                    {{ csrf_field() }}
                    <div class="panel-body">
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <table id="absensi" class="table table-bordred table-striped">
                                    <thead>
                                        <tr>
                                            <th width="3%" class="text-center">No</th>
                                            {{-- <th width="20%">QR Code</th> --}}
                                            <th width="30%">NIP</th>
                                            <th width="35%">Nama Pegawai</th>
                                            <th width="32%">Kehadiran</th>
                                        </tr>
                                    </thead>

                                    <tbody id="isi">
                                        @foreach ($pegawai as $index => $pegawai)
                                            <tr>
                                                <input type="hidden" name="pegawai[]" value="{{ $pegawai->id_pegawai }}">
                                                <td class="text-center">{{ $index + 1 }}</td>
                                                {{-- <td><img width="60" src="{{ asset($pegawai->qr_code_path) }}" alt="QR Code" /></td> --}}
                                                <td>{{ $pegawai->NIP }}</td>
                                                <td>{{ $pegawai->Nama }}</td>
                                                <td>
                                                    @if ($pegawai->presensiGuru)
                                                        @foreach ($pegawai->presensi as $absen)
                                                            @if ($absen->pivot->tanggal == Carbon\Carbon::now('Asia/Jakarta')->format('Y-m-d'))
                                                                <p>{{ $absen->pivot->status }}</p>
                                                            @break

                                                        @else
                                                            @if ($loop->last)
                                                                <label class="radio-inline">
                                                                    <input id="aktif" type="radio"
                                                                        name="status[{{ $index }}]"
                                                                        value="Hadir" checked>Hadir
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input id="aktif" type="radio"
                                                                        name="status[{{ $index }}]"
                                                                        value="Alfa">Alfa
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input id="aktif" type="radio"
                                                                        name="status[{{ $index }}]"
                                                                        value="Izin">Izin
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input id="aktif" type="radio"
                                                                        name="status[{{ $index }}]"
                                                                        value="Sakit">Sakit
                                                                </label>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                @else
                                                    <label class="radio-inline">
                                                        <input id="aktif" type="radio"
                                                            name="status[{{ $index }}]" value="Hadir"
                                                            checked>Hadir
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input id="aktif" type="radio"
                                                            name="status[{{ $index }}]" value="Alfa">Alfa
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input id="aktif" type="radio"
                                                            name="status[{{ $index }}]" value="Izin">Izin
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input id="aktif" type="radio"
                                                            name="status[{{ $index }}]" value="Sakit">Sakit
                                                    </label>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <p data-placement="top" data-toggle="tooltip" title="Add" class="pull-right"><button
                                class="btn btn-primary btn-sm" type="submit" data-title="Add">Submit</button></p>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-sm-12">
            <p class="back-link">&copy; <?php echo date('Y'); ?> SDN 88 Bengkulu Tengah</p>
        </div>
    </div><!--/.row-->
</div>
</div>
@endsection
