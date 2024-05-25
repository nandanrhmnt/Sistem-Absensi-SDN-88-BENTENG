<?php

namespace App\Http\Controllers;

use App\TbPegawai;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PegawaiController extends Controller
{
    public function index()
    {
        $resource = TbPegawai::all();
        return view('admin.pegawai', ['resource' => $resource]);
    }

    public function create(Request $request)
    {
        // dd($request->all());
        // Periksa apakah keterangan pegawai adalah "honorer"
        $isHonorer = strtolower($request->keterangan) === 'honorer';

        // Periksa apakah NIP kosong
        if ($isHonorer && $request->nip) {
            session()->flash('notif', ['success' => false, 'msgaction' => 'Tambah Data Gagal, NIP Harus Kosong untuk Keterangan Honorer!']);
            return redirect('/pegawai');
        }

        // Periksa apakah keterangan pegawai adalah "guru" dan NIP kosong
        if (!$isHonorer && empty($request->nip)) {
            session()->flash('notif', ['success' => false, 'msgaction' => 'Tambah Data Gagal, NIP Tidak Boleh Kosong untuk Keterangan Guru!']);
            return redirect('/pegawai');
        }

        // Buat instance baru dari TbPegawai
        $Pegawai = new TbPegawai;
        $Pegawai->NIP = $request->nip;
        $Pegawai->Nama = $request->nama;
        $Pegawai->jenis_kelamin = $request->jk;
        $Pegawai->keterangan = $request->keterangan;
        $Pegawai->No_hp = $request->no_hp;

        // Simpan data ke database
        if ($Pegawai->save()) {
            session()->flash('notif', ['success' => true, 'msgaction' => 'Tambah Data Berhasil!']);
        } else {
            session()->flash('notif', ['success' => false, 'msgaction' => 'Tambah Data Gagal, Silahkan Ulangi!']);
        }

        return redirect('/pegawai');
    }

    public function update(Request $request, $id)
    {
        // Temukan pegawai berdasarkan id
        $pegawai = TbPegawai::find($id);

        // Jika pegawai tidak ditemukan, tambahkan pesan kesalahan dan kembalikan ke halaman sebelumnya
        if (!$pegawai) {
            session()->flash('notif', array('success' => false, 'msgaction' => 'Pegawai tidak ditemukan!'));
            return redirect('/pegawai');
        }

        // Cek apakah keterangan adalah "honorer"
        $isHonorer = $request->keterangan == 'Honorer';

        // Jika keterangan adalah "honorer" dan NIP tidak kosong, tambahkan pesan kesalahan
        if ($isHonorer && $request->NIP) {
            session()->flash('notif', array('success' => false, 'msgaction' => 'Edit Data Gagal, NIP Harus Kosong untuk Keterangan Honorer!'));
            return redirect('/pegawai');
        }

        // Jika keterangan adalah "guru" dan NIP kosong, tambahkan pesan kesalahan
        if (!$isHonorer && !$request->NIP) {
            session()->flash('notif', array('success' => false, 'msgaction' => 'Edit Data Gagal, NIP Tidak Boleh Kosong untuk Keterangan Guru!'));
            return redirect('/pegawai');
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

        return redirect('/pegawai');
    }

    public function delete($id_pegawai)
    {
        TbPegawai::find($id_pegawai)->delete();
        session()->flash('notif', array('success' => true, 'msgaction' => 'Hapus Data Berhasil!'));
        return redirect('/pegawai');
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
                    <a href="/pegawai/delete/<?php $res->id_pegawai ?>" onclick="return confirm('yakin data akan di hapus ?')" class="btn btn-danger btn-xs" title="Delete">
                        <span class="glyphicon glyphicon-trash"></span>
                    </a>
                </td>
            </tr>
<?php
            $index++;
        }
    }
}
