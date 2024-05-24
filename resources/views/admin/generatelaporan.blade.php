@extends('layouts.master')
@section('title', 'Generate Laporan')
@section('content')
    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="#"><em class="fa fa-home"></em></a></li>
                <li class="active">Admin</li>
                <li class="active">Generate Laporan</li>
            </ol>
        </div><!--/.row-->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">Generate Laporan</div>
                    <div class="panel-body">
                        <div class="row">
                            <!-- Laporan Absen Guru -->
                            <div class="col-md-6">
                                <div class="panel panel-default">
                                    <div class="panel-heading">Laporan Absen Guru</div>
                                    <div class="panel-body">
                                        <form id="formGuru" action="{{ route('admin.generateLaporanGuru') }}"
                                            method="post">
                                            @csrf
                                            <input type="hidden" name="keterangan" value="Guru">
                                            <div class="form-group">
                                                <label for="bulan">Bulan:</label>
                                                <div class="col-5">
                                                    <input type="month" name="tanggalGuru" id="tanggalGuru"
                                                        class="form-control" value="{{ date('Y-m') }}">
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-danger"
                                                onclick="generatePDF('formGuru')">GENERATE PDF</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- Laporan Absen Honorer -->
                            <div class="col-md-6">
                                <div class="panel panel-default">
                                    <div class="panel-heading">Laporan Absen Honorer</div>
                                    <div class="panel-body">
                                        <form id="formHonorer" action="{{ route('admin.generateLaporanHonorer') }}"
                                            method="post">
                                            @csrf
                                            <input type="hidden" name="keterangan" value="Honorer">
                                            <div class="form-group">
                                                <label for="bulan">Bulan:</label>
                                                <div class="col-5">
                                                    <input type="month" name="tanggalHonorer" id="tanggalHonorer"
                                                        class="form-control" value="{{ date('Y-m') }}">
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-danger"
                                                onclick="generatePDF('formHonorer')">GENERATE PDF</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
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
@section('js')
    <script>
        function generatePDF(formId) {
            event.preventDefault();

            if (formId === 'formGuru') {
                document.getElementById(formId).action = "{{ route('admin.generateLaporanGuru') }}";
            } else if (formId === 'formHonorer') {
                document.getElementById(formId).action = "{{ route('admin.generateLaporanHonorer') }}";
            }
            document.getElementById(formId).submit();
        }
    </script>
@endsection
