@extends('layouts.master')
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.dataTables.css">
@endsection
@section('title', 'Data Pegawai')
@section('content')
    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="#">
                        <em class="fa fa-home"></em>
                    </a></li>
                <li class="active">Admin</li>
                <li class="active">Data Pegawai</li>
            </ol>
        </div><!--/.row-->
        @if (session()->exists('notif'))
            @if (session()->get('notif')['success'])
                {!! '<div class="alert alert-success alert-dismissable">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                        <strong>Sukses! </strong>' .
                    session()->get('notif')['msgaction'] .
                    '
                    </div>' !!}
            @else
                {!! '<div class="alert alert-danger alert-dismissable">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                        <strong>Gagal! </strong>' .
                    session()->get('notif')['msgaction'] .
                    '
                    </div>' !!}
            @endif
        @endif
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">Data Pegawai</div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <div class="panel-footer">
                                    <p data-placement="top" data-toggle="tooltip" title="Add" class="pull-right">
                                        <button class="btn btn-primary btn-sm" data-title="Add" data-toggle="modal"
                                            data-target="#add"><span class="glyphicon glyphicon-plus"></span></button>
                                    </p>
                                </div>
                                <table id="absensi" class="table table-bordred table-striped">
                                    <thead>
                                        <tr>
                                            <th width="3%" class="text-center">No</th>
                                            <th width="20%">NIP</th>
                                            <th width="25%">Nama</th>
                                            <th width="20%">QR</th>
                                            <th width="15%">Jenis Kelamin</th>
                                            <th width="20%">No Hp</th>
                                            <th width="10%">Keterangan</th>
                                            <th width="10%" class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="isi">
                                        @foreach ($resource as $index => $res)
                                            <tr>
                                                <td class="text-center">
                                                    {{ $index + 1 }}
                                                </td>
                                                <td>{{ $res->NIP ? $res->NIP : '-' }}</td>
                                                <td>{{ $res->Nama }}</td>
                                                <td>{!! QrCode::size(50)->generate($res->id_pegawai) !!}</td>
                                                <td>{{ $res->jenis_kelamin == 'Laki-laki' ? 'Laki-Laki' : 'Perempuan' }}
                                                </td>
                                                <td>{{ $res->No_hp }}</td>
                                                <td>{{ $res->keterangan }}</td>
                                                <td class="text-center">
                                                    <div class="d-flex">
                                                        <button data-toggle="modal"
                                                            class="edit-button btn btn-primary btn-xs"
                                                            data-target="#editModal{{ $res->id_pegawai }}">
                                                            <span class="glyphicon glyphicon-pencil"></span>
                                                        </button>
                                                        <button class="delete-button btn btn-danger btn-xs"
                                                            data-toggle="modal"
                                                            data-target="#deleteModal{{ $res->id_pegawai }}">
                                                            <span class="glyphicon glyphicon-trash"></span>
                                                        </button>
                                                    </div>
                                                </td>

                                                <!-- Edit Modal -->
                                                <div id="editModal{{ $res->id_pegawai }}" class="modal fade" role="dialog">
                                                    <div class="modal-dialog">
                                                        <!-- Modal content-->
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal">&times;</button>
                                                                <h4 class="modal-title">Edit Pegawai</h4>
                                                            </div>
                                                            <form action="/pegawai/update/{{ $res->id_pegawai }}"
                                                                method="post">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="id_pegawai"
                                                                    value="{{ $res->id_pegawai }}">
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-lg-6">
                                                                            <div class="form-group">
                                                                                <label
                                                                                    for="nip{{ $res->id_pegawai }}">NIP</label>
                                                                                <input type="number" name="NIP"
                                                                                    class="form-control"
                                                                                    id="nip{{ $res->id_pegawai }}"
                                                                                    value="{{ $res->NIP }}"
                                                                                    placeholder="NIP">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            <div class="form-group">
                                                                                <label
                                                                                    for="nama{{ $res->id_pegawai }}">Nama</label>
                                                                                <input type="text" name="nama"
                                                                                    class="form-control"
                                                                                    id="nama{{ $res->id_pegawai }}"
                                                                                    value="{{ $res->Nama }}"
                                                                                    placeholder="Nama">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-12">
                                                                            <div class="form-group">
                                                                                <label for="jk{{ $res->id_pegawai }}">Jenis
                                                                                    Kelamin</label>
                                                                                <select class="form-control"
                                                                                    id="jk{{ $res->id_pegawai }}"
                                                                                    name="jk">
                                                                                    <option disabled>--Pilih Jenis
                                                                                        Kelamin--</option>
                                                                                    <option value="Laki-Laki"
                                                                                        {{ $res->jenis_kelamin == 'Laki-Laki' ? 'selected' : '' }}>
                                                                                        Laki-Laki</option>
                                                                                    <option value="Perempuan"
                                                                                        {{ $res->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>
                                                                                        Perempuan</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-12">
                                                                            <div class="form-group">
                                                                                <label for="no_hp{{ $res->id_pegawai }}"
                                                                                    class="control-label">No Hp</label>
                                                                                <input type="number" name="no_hp"
                                                                                    class="form-control"
                                                                                    id="no_hp{{ $res->id_pegawai }}"
                                                                                    placeholder="No Hp"
                                                                                    value="{{ $res->No_hp }}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-12">
                                                                            <div class="form-group">
                                                                                <label for="keterangan">Keterangan</label>
                                                                                <select class="form-control"
                                                                                    id="keterangan{{ $res->id_pegawai }}"
                                                                                    name="keterangan">
                                                                                    <option disabled>--Pilih
                                                                                        Keterangan--</option>
                                                                                    <option value="Guru"
                                                                                        {{ $res->keterangan == 'Guru' ? 'selected' : '' }}>
                                                                                        Guru</option>
                                                                                    <option value="Honorer"
                                                                                        {{ $res->keterangan == 'honorer' ? 'selected' : '' }}>
                                                                                        Honorer</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-info btn-lg"
                                                                        style="width: 100%;">
                                                                        <span class="glyphicon glyphicon-edit"></span>
                                                                        Update
                                                                        Data
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Edit Modal -->

                                                <!-- Delete Modal -->
                                                <div class="modal fade" id="deleteModal{{ $res->id_pegawai }}"
                                                    tabindex="-1" role="dialog" aria-labelledby="edit"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <form method="post"
                                                                action="/pegawai/delete/{{ $res->id_pegawai }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <div class="modal-header">
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-hidden="true"><span
                                                                            class="glyphicon glyphicon-remove"
                                                                            aria-hidden="true"></span></button>
                                                                    <h4 class="modal-title custom_align" id="Heading">
                                                                        Delete
                                                                        this entry</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="alert alert-danger"><span
                                                                            class="glyphicon glyphicon-warning-sign"></span>
                                                                        Are you
                                                                        sure to delete this data?</div>
                                                                </div>
                                                                <div class="modal-footer ">
                                                                    <button type="submit" class="btn btn-success"><span
                                                                            class="glyphicon glyphicon-ok-sign"></span> Yes</button>
                                                                    <button type="button" class="btn btn-default"
                                                                        data-dismiss="modal"><span
                                                                            class="glyphicon glyphicon-remove"></span> No</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Delete Modal -->

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <p class="back-link">&copy; <?php echo date('Y'); ?> SDN 88 Bengkulu Tengah</p>
                </div>
            </div><!--/.row-->
        </div>
    </div>

    <!-- Modal CRUD Content -->

    <!-- Add Modal -->
    <div id="add" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Tambah Data</h4>
                </div>
                <form action="/pegawai" method="post">
                    @method('POST')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="nip">NIP</label>
                                    <input type="number" name="nip" class="form-control" placeholder="NIP">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" name="nama" class="form-control" placeholder="Nama">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="jk">Jenis Kelamin</label>
                                    <select class="form-control" id="jk" name="jk">
                                        <option selected disabled>--Pilih Jenis Kelamin--</option>
                                        <option value="Laki-Laki">Laki-Laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label">No Hp</label>
                                    <input type="number" name="no_hp" class="form-control" id="no_hp"
                                        placeholder="No Hp">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="jk">Keterangan</label>
                                    <select class="form-control" id="jk" name="keterangan">
                                        <option selected disabled>--Pilih Keterangan--</option>
                                        <option value="Guru">Guru</option>
                                        <option value="Honorer">Honorer</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer ">
                        <button type="submit" class="btn btn-info btn-lg" style="width: 100%;"><span
                                class="glyphicon glyphicon-plus"></span> Tambah Data</button>
                    </div>
                    {!! csrf_field() !!}
                </form>
            </div>
        </div>
    </div>
    <!--/add Modal -->

@endsection
@section('js')
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.print.min.js"></script>
    <script>
        $(document).ready(function() {
            new DataTable('#absensi', {
                layout: {
                    topStart: {
                        buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                    }
                }
            });
        });
    </script>
@endsection
