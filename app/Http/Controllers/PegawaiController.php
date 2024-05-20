<?php

namespace App\Http\Controllers;

use App\TbPegawai;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PegawaiController extends Controller
{
    public function all()
    {
        $resource = TbPegawai::paginate(10);
        return view('admin.pegawai', ['resource' => $resource]);
    }
    
    public function guru()
    {
        $resource = TbPegawai::where('keterangan', 'guru')->paginate(10);
        return view('admin.pegawai', ['resource' => $resource]);
    }
    
    public function honorer()
    {
        $resource = TbPegawai::where('keterangan', 'honorer')->paginate(10);
        return view('admin.pegawai', ['resource' => $resource]);
    }
    
    public function create(Request $request)
    {
        // dd($request);
        // Cek apakah keterangan adalah "honorer"
        $isHonorer = strtolower($request->keterangan) === 'honorer';
        
        // // Jika bukan honorer, cek apakah NIP sudah ada di database
        // if (!$isHonorer && TbPegawai::where(['NIP' => $request->NIP])->exists()) {
            //     session()->flash('notif', array('success' => false, 'msgaction' => 'Tambah Data Gagal, Data Telah Ada!'));
            //     return redirect('/admin/all');
            // }
            
            // Buat instance baru dari TbPegawai
            $Pegawai = new TbPegawai;
            $Pegawai->NIP = $request->nip;
            $Pegawai->Nama = $request->nama;
            $Pegawai->jenis_kelamin = $request->jk;
            $Pegawai->keterangan = $request->keterangan;
            $Pegawai->No_hp = $request->no_hp;
            
            // Simpan data ke database
            if ($Pegawai->save()) {
                session()->flash('notif', array('success' => true, 'msgaction' => 'Tambah Data Berhasil!'));
                return redirect('/admin/all');
            } else {
                session()->flash('notif', array('success' => false, 'msgaction' => 'Tambah Data Gagal, Silahkan Ulangi!'));
                return redirect('/admin/all');
            }
        }
        
        public function update(Request $request, $id)
        {
            // Temukan pegawai berdasarkan id
            $pegawai = TbPegawai::find($id);
            
            // Jika pegawai tidak ditemukan, tambahkan pesan kesalahan dan kembalikan ke halaman sebelumnya
            if (!$pegawai) {
                session()->flash('notif', array('success' => false, 'msgaction' => 'Pegawai tidak ditemukan!'));
                return redirect('/admin/all');
            }
            
            // Cek apakah keterangan adalah "honorer"
            $isHonorer = $request->keterangan == 'Honorer';
            
            // Jika keterangan adalah "honorer" dan NIP tidak kosong, tambahkan pesan kesalahan
            if ($isHonorer && $request->NIP) {
                session()->flash('notif', array('success' => false, 'msgaction' => 'Edit Data Gagal, NIP Harus Kosong untuk Keterangan Honorer!'));
                return redirect('/admin/all');
            }
            
            // Jika keterangan adalah "guru" dan NIP kosong, tambahkan pesan kesalahan
            if (!$isHonorer && !$request->NIP) {
                session()->flash('notif', array('success' => false, 'msgaction' => 'Edit Data Gagal, NIP Tidak Boleh Kosong untuk Keterangan Guru!'));
                return redirect('/admin/all');
            }
            
            // Update data pegawai
            $pegawai->NIP = $request->NIP;
            $pegawai->Nama = $request->nama;
            $pegawai->jenis_kelamin = $request->jk;
            $pegawai->No_hp = $request->no_hp;
            $pegawai->keterangan = $request->keterangan;
            
            // Simpan perubahan
            if ($pegawai->save()) {
                session()->flash('notif', array('success' => true, 'msgaction' => 'Edit Data Berhasil!'));
            } else {
                session()->flash('notif', array('success' => false, 'msgaction' => 'Edit Data Gagal, Silahkan Ulangi!'));
            }
            
            return redirect('/admin/all');
        }
        
        
        
        public function delete($id_pegawai)
        {
            // dd($id_pegawai);
            TbPegawai::find($id_pegawai)->delete();
            session()->flash('notif', array('success' => true, 'msgaction' => 'Hapus Data Berhasil!'));
            return redirect('/admin/all');
        }
        public function show($id_pegawai)
        {
            $resource = TbPegawai::find($id_pegawai);
            return view('Admin/pegawai', ['resource' => $resource]);
        }
        public function search(Request $request)
        {
            $key = $request->key;
            if ($key != "") {
                $resource = TbPegawai::where('NIP', 'like', '%' . $key . '%')
                ->orWhere('Nama', 'like', '%' . $key . '%')
                ->orWhere('jenis_kelamin', 'like', '%' . $key . '%')
                ->orWhere('No_hp', 'like', '%' . $key . '%')
                ->orWhere('keterangan', 'like', '%' . $key . '%')
                ->paginate(10);
            } else {
                $resource = TbPegawai::paginate(10);
            }
            if (count($resource) == 0) {
                echo "<td colspan='9' class='text-center'>Tidak ada data</td>";
            }
            $index = 1;
            foreach ($resource as $res) {
                ?>
                <tr>
                <td class="text-center"><?php echo $index ?></td>
                <td><?php echo $res->NIP ?></td>
                <td><?php echo $res->Nama ?></td>
                <td><?php echo QrCode::size(50)->generate($res->id_pegawai) ?></td>
                <td class="text-center"><?php if ($res->jenis_kelamin == "L") {
                    echo 'Laki-Laki';
                } else {
                    echo 'Perempuan';
                } ?></td>
                <td><?php echo $res->No_hp ?></td>
                <td class="text-center"><?php if ($res->keterangan == "G") {
                    echo 'Guru';
                } else {
                    echo 'Honorer';
                } ?></td>
                <td class="text-center">
                <p data-placement="top" data-toggle="tooltip" title="Edit"><button data-aksi="pegawai" data-nama="<?php echo $res->nama ?>" data-id="<?php echo $res->id_pegawai ?>" data-keterangan="<?php echo $res->keterangan ?>" data-jk="<?php echo $res->jenis_kelamin ?>" data-No_hp="<?php echo $res->No_hp ?>" class="edit-button btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" data-target="#edit"><span class="glyphicon glyphicon-pencil"></span></button></p>
                </td>
                <td class="text-center">
                <p data-placement="top" data-toggle="tooltip" title="Delete"> <a class="btn btn-" href="/pegawai/delete/<?php $res->id_pegawai ?>"></a></p>
                </td>
                </tr>
                <?php
                $index++;
            }
        }
    }
    