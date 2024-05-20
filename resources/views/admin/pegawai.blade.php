@extends('layouts.master')
@section('title', 'Web Presensi | Data Pegawai')
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
                            <table id="absensi" class="table table-bordred table-striped">
                                
                                <thead>
                                    <tr>
                                        <input type="text" name="search" class="form-control" placeholder="Cari...">
                                    </tr>
                                    <tr>
                                        <th width="3%" class="text-center">No</th>
                                        <th width="20%">NIP</th>
                                        <th width="25%">Nama</th>
                                        <th width="20%">QR</th>
                                        <th width="15%">Jenis Kelamin</th>
                                        <th width="20%">No Hp</th>
                                        <th width="10%">Keterangan</th>
                                        <th width="10%" colspan="2" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="isi">
                                    @foreach ($resource as $index => $res)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>{{ $res->NIP ?? '-' }}</td>
                                        <td>{{ $res->Nama }}</td>
                                        <td>{!! QrCode::size(50)->generate($res->id_pegawai) !!}</td>
                                        <td>{{ $res->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}</td>
                                        <td>{{ $res->No_hp }}</td>
                                        <td>{{ $res->keterangan }}</td>
                                        <td class="text-center">
                                            <button
                                            data-aksi="pegawai"
                                            data-id="{{ $res->id_pegawai }}"
                                            data-nama="{{ $res->Nama }}"
                                            data-no_hp="{{ $res->No_hp }}"
                                            data-jk="{{ $res->jenis_kelamin }}"
                                            data-nip="{{ $res->NIP }}"
                                            data-keterangan="{{ $res->keterangan }}"
                                            class="edit-button btn btn-primary btn-xs"
                                            data-toggle="modal"
                                            data-target="#editModal{{ $res->id_pegawai }}"
                                            >
                                            <span class="glyphicon glyphicon-pencil"></span>
                                        </button>
                                    </td>
                                    <td class="text-center">
                                        <a href="/pegawai/delete/{{ $res->id_pegawai }}" class="btn btn-danger btn-xs" title="Delete">
                                            <span class="glyphicon glyphicon-trash"></span>
                                        </a>
                                    </td>
                                </tr>
                                
                                <!-- Edit Modal -->
                                <div id="editModal{{ $res->id_pegawai }}" class="modal fade" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Edit Pegawai</h4>
                                            </div>
                                            <form action="/pegawai/update/{{ $res->id_pegawai }}" method="post">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="id_pegawai" value="{{ $res->id_pegawai }}">
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="nip">NIP</label>
                                                                <input type="number" name="NIP" class="form-control" id="nip{{ $res->id_pegawai }}" placeholder="NIP">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="nama">Nama</label>
                                                                <input type="text" name="nama" class="form-control" id="nama{{ $res->id_pegawai }}" placeholder="Nama">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label for="jk">Jenis Kelamin</label>
                                                                <select class="form-control" id="jk{{ $res->id_pegawai }}" name="jk">
                                                                    <option selected disabled>--Pilih Jenis Kelamin--</option>
                                                                    <option value="Laki-Laki">Laki-Laki</option>
                                                                    <option value="Perempuan">Perempuan</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label class="control-label">No Hp</label>
                                                                <input type="number" name="no_hp" class="form-control" id="no_hp{{ $res->id_pegawai }}" placeholder="No Hp">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label for="keterangan">Keterangan</label>
                                                                <select class="form-control" id="keterangan{{ $res->id_pegawai }}" name="keterangan">
                                                                    <option selected disabled>--Pilih Keterangan--</option>
                                                                    <option value="Guru">Guru</option>
                                                                    <option value="Honorer">Honorer</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-info btn-lg" style="width: 100%;">
                                                        <span class="glyphicon glyphicon-edit"></span> Update Data
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </tbody>
                            
                        </table>
                        
                    </div>
                    <ul class="pagination pull-right">
                        {!! $resource->render() !!}
                    </ul>
                </div>
                <div class="panel-footer">
                    <p data-placement="top" data-toggle="tooltip" title="Add" class="pull-right"><button
                        class="btn btn-primary btn-sm" data-title="Add" data-toggle="modal"
                        data-target="#add"><span class="glyphicon glyphicon-plus"></span></button></p>
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

<!-- Edit Modal -->

<!--/Edit Modal -->

<!-- Add Modal -->
<div id="add" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Tambah Data</h4>
            </div>
            <form action="/pegawai/" method="post">
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
    
    <!-- Delete modal -->
    <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="delete-form" method="post" action="">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span
                            class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                            <h4 class="modal-title custom_align" id="Heading">Delete this entry</h4>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> Are you
                                sure to delete this data?</div>
                            </div>
                            <div class="modal-footer ">
                                <button type="submit" class="btn btn-success"><span
                                    class="glyphicon glyphicon-ok-sign"></span> Yes</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal"><span
                                        class="glyphicon glyphicon-remove"></span> No</button>
                                    </div>
                                    {!! csrf_field() !!}
                                    {{ method_field('DELETE') }}
                                </form>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!--/Delete modal -->
                    
                    @endsection
                    @section('js')
                    <script>
                        $('input[name="search"]').keyup(function() {
                            $.ajax({
                                type: 'POST',
                                data: {
                                    key: $(this).val(),
                                    _method: 'POST',
                                    _token: $('meta[name="csrf-token"]').attr('content')
                                },
                                url: '/pegawai/search/',
                                success: function(html) {
                                    $('#isi').html(html)
                                }
                            });
                        })
                    </script>
                    
                    <script>
                        $(document).ready(function() {
                            $('.edit-button').on('click', function() {
                                var id = $(this).data('id');
                                var nip = $(this).data('nip');
                                var nama = $(this).data('nama');
                                var jk = $(this).data('jk');
                                var no_hp = $(this).data('no_hp');
                                var keterangan = $(this).data('keterangan');
                                
                                $('#editModal' + id + ' #nip' + id).val(nip);
                                $('#editModal' + id + ' #nama' + id).val(nama);
                                $('#editModal' + id + ' #jk' + id).val(jk);
                                $('#editModal' + id + ' #no_hp' + id).val(no_hp);
                                $('#editModal' + id + ' #keterangan' + id).val(keterangan);
                                
                                $('#delete').on('show.bs.modal', function (event) {
                                    var button = $(event.relatedTarget);
                                    var url = button.data('url');
                                    var modal = $(this);
                                    modal.find('form').attr('action', url);
                                });
                            });
                        });
                    </script>
                    
                    @endsection
                    