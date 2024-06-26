<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //fungsi eloquent menampilkan data menggunakan pagination
        $users = User::orderBy('id', 'asc')->get();
        return view('users.users', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.add_users');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //melakukan validasi data
        $request->validate([
            'name' => 'required',
            'nik' => 'required',
            'gender' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        // Enkripsi password sebelum menyimpan ke database
        $password = Hash::make($request->password);

        //fungsi eloquent untuk menambah data
        User::create([
            'name' => $request->name,
            'nik' => $request->nik,
            'gender' => $request->gender,
            'phone' => $request->phone,
            'address' => $request->address,
            'email' => $request->email,
            'password' => $password,
        ]);

        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('users')
            ->with('success', 'Karyawan Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $User = User::find($id);
        return view('users.detail_users', compact('User'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $User = User::find($id);
        return view('users.edit_users', compact('User'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //melakukan validasi data
        $request->validate([
            'name' => 'required',
            'nik' => 'required',
            'gender' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        // Enkripsi password sebelum menyimpan ke database
        $password = Hash::make($request->password);

        //fungsi eloquent untuk mengupdate data inputan
        User::find($id)->update([
            'name' => $request->name,
            'nik' => $request->nik,
            'gender' => $request->gender,
            'phone' => $request->phone,
            'address' => $request->address,
            'email' => $request->email,
            'password' => $password,
        ]);

        //jika data berhasil diupdate, akan kembali ke halaman utama
        return redirect()->route('users.profile')
            -> with('success', 'Profil Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //fungsi eloquent untuk menghapus data
        User::find($id)->delete();
        return redirect()->route('users')
            ->with('success', 'Karyawan Berhasil Dihapus');
    }

    public function profile()
    {
        $users = Auth::user();
        return view('users.account', compact('users'));
    }

    public function showPasswordForm()
    {
        return view('users.password_form');
    }

    public function validatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);

        if ($request->password === 'harihari2022') {
            $request->session()->put('users_password', true);
            return redirect()->route('users');
        }

        return redirect()->route('users.password.form')->withErrors(['password' => 'Password salah']);
    }
}
