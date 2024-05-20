@extends('layouts.master')
@section('title', 'Web Presensi | Laporan')
@section('content')
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#">
                <em class="fa fa-home"></em>
                </a></li>
            <li class="active">Admin</li>
            <li class="active">Generate Laporan</li>
        </ol>
    </div><!--/.row-->
    @if(session()->exists('notif'))
    @if(session()->get('notif')['success'])
    {!! 
    '<div class="alert alert-success alert-dismissable"> 
    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
    <strong>Sukses! </strong>'. session()->get('notif')['msgaction'] .'
    </div>' 
    !!}
    @else
    {!! 
    '<div class="alert alert-danger alert-dismissable"> 
    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
    <strong>Gagal! </strong>'. session()->get('notif')['msgaction'] .'
    </div>' 
    !!}
    @endif
    @endif
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">Rekap Presensi Pegawai {{ $keterangan }}</div>
                <div class="panel-body">
                    <form action="/rekap/pribadipdf/" method="post">
                        {{ csrf_field()}}
                        <input type="hidden" name="id" value="{{$resource->id_pegawai}}">
                        <input type="hidden" name="tanggal_awal">
                        <input type="hidden" name="tanggal_akhir">
                        <div class="table-responsive">
                            <table id="absensi" class="table table-bordred table-striped">
                                <thead>
                                    <tr>
                                        <th colspan="8">
                                            <div class="form-group">
                                                <div class='input-group date' id='datetimepicker1'>
                                                    <input type='text' id="demo" class="form-control" />
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </th>
                                        <th>
                                            <button type="submit" class="btn btn-danger">PDF</button>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th width="3%" class="text-center">No</th>
                                       <!--  <th width="20%">QR</th> -->
                                        <th width="20%">NIP</th>
                                        <th width="20%">Nama Pegawai</th>
                                        <th width="20%">Tanpa keterangan</th>
                                        <th width="20%">Izin</th>
                                        <th width="20%">Sakit</th>
                                    </tr>
                                </thead>

                                <tbody id="isi">
                                    @foreach ($resource->pegawai as  $index => $res)
                                    <tr>
                                        <td class="text-center">{{ $index+1 }}</td>
                                        <!-- <td><img width="60" src="data:image/png;base64,{{DNS2D::getBarcodePNG($res['nis'], 'QRCODE')}}" alt="barcode"/></td> -->
                                        <td>{{ $res->NIP}}</td>
                                        <td>{{ $res->Nama}}</td>
                                        <td>{{ count(App\Kehadiran::where(['id_pegawai'=>$res->id_pegawai, 'kehadiran'=>'Tanpa keterangan'])->get()) }}</td>
                                        <td>{{ count(App\Kehadiran::where(['id_pegawai'=>$res->id_pegawai, 'kehadiran'=>'Izin'])->get()) }}</td>
                                        <td>{{ count(App\Kehadiran::where(['id_pegawai'=>$res->id_pegawai, 'kehadiran'=>'Sakit'])->get()) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-sm-12">
                <p class="back-link">&copy; <?php echo date('Y') ?> SDN 88 Bengkulu Tengah</p>
            </div>
        </div><!--/.row-->
    </div>
</div>
@endsection
@section('js')
<script>
    moment.locale('id');
    $('#demo').daterangepicker({
        "ranges": {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        "alwaysShowCalendars": true,
        "startDate": moment().format('L'),
        "endDate": moment().format('L')
    }, function(start, end, label) {
        $.ajax({
            type : 'POST', 
            data :{
                id : $('input[name="id"]').val(),
                tanggal_awal : start.format('YYYY-M-Do'),
                tanggal_akhir : end.format('YYYY-M-Do'),
                _method : 'POST',
                _token : $('meta[name="csrf-token"]').attr('content')
            },
            url  : '/rekap/', 
            success : function(html){
                $('#isi').html(html)
            }
        });  
        $('input[name="tanggal_awal"]').val(start.format('YYYY-M-Do'));
        $('input[name="tanggal_akhir"]').val(end.format('YYYY-M-Do'));
        console.log(start.format('YYYY-M-Do'));
    });
</script>
@endsection
