<?php

namespace App\Http\Controllers;

use App\User;
use App\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AuthController extends Controller
{
    function showForm()
    {

        return view('auth/login');
    }
    function lists()
    {
        $resource = User::paginate(10);
        return view('admin/akun', ['resource' => $resource]);
    }
    function delete($id)
    {
        User::find($id)->delete();
        session()->flash('notif', array('success' => true, 'msgaction' => 'Hapus Data Berhasil!'));
        return redirect('/admin/akun');
    }
    function login(Request $req)
    {
        $credentials = $req->only('username', 'password');

        if (Auth::attempt($credentials, true)) {
            return redirect('/');
        } else {
            return redirect()->back()->withErrors(['loginError' => 'Tidak dapat memasukkan Anda. Silahkan periksa username dan password Anda.']);
        }
    }

    function logout()
    {
        if (Auth::check()) {
            Auth::logout();
        }
        return redirect('/login');
    }
}
