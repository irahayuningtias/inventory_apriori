<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;



class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            //fungsi eloquent menampilkan data menggunakan pagination
            $users = User::orderBy('id', 'asc')->get();
            return view('users.users', compact('users'));
        } catch (QueryException $e) {
            // Menangani kesalahan duplikasi entri
            if ($e->errorInfo[1] == 1062) {
                return redirect()->route('users')->withErrors('Duplicate entry detected. Please use a unique identifier.');
            }

            // Menangani kesalahan referensi foreign key
            if ($e->errorInfo[1] == 1452) {
                return redirect()->route('users')->withErrors('Invalid category reference. Please select a valid category.');
            }

            // Menangani kesalahan lainnya
            return redirect()->route('users')->withErrors('An error occurred: ' . $e->getMessage());
        } catch (ValidationException $e) {
            // Menangani kesalahan validasi
            return redirect()->route('users')->withErrors($e->errors());
        } catch (\Exception $e) {
            // Menangani kesalahan umum
            return redirect()->route('users')->withErrors('An error occurred: ' . $e->getMessage());
        }
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
        try {
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
        } catch (QueryException $e) {
            // Menangani kesalahan duplikasi entri
            if ($e->errorInfo[1] == 1062) {
                return redirect()->route('users.create')->withErrors('Duplicate entry detected. Please use a unique identifier.');
            }

            // Menangani kesalahan referensi foreign key
            if ($e->errorInfo[1] == 1452) {
                return redirect()->route('users.create')->withErrors('Invalid category reference. Please select a valid category.');
            }

            // Menangani kesalahan lainnya
            return redirect()->route('users.create')->withErrors('An error occurred: ' . $e->getMessage());
        } catch (ValidationException $e) {
            // Menangani kesalahan validasi
            return redirect()->route('users.create')->withErrors($e->errors());
        } catch (\Exception $e) {
            // Menangani kesalahan umum
            return redirect()->route('users.create')->withErrors('An error occurred: ' . $e->getMessage());
        }
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
