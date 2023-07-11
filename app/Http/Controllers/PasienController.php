<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class PasienController extends Controller
{
    public function index(): View
    {
        $user = User::where('role', 0)->get();

        return view('admin.datapasien.indexp', compact('user'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'alamat' => 'required',
            'jenis_kelamin' => 'required',
            'umur' => 'required',
            'password' => 'required',
        ],
        [
            'name.required' => 'Name tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'alamat.required' => 'Alamat tidak boleh kosong',
            'jenis_kelamin.required' => 'Jenis Kelamin tidak boleh kosong',
            'umur.required' => 'umur tidak boleh kosong',
            'password.required' => 'Password tidak boleh kosong',
        ]
    );

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "alamat" => $request->alamat,
            "jenis_kelamin" => $request->jenis_kelamin,
            "umur" => $request->umur,
            "password" => bcrypt($request->password),
            "role" => "0",
        ]);

        // return redirect()->route('datapasien.index')->with(['success' => 'Data berhasil ditambahkan']);

        if ($request) {
            return redirect()->route('datapasien.index')->with('success', 'Data pasien berhasil ditambahkan');
        } else {
            return redirect()->route('datapasien.index')->with('error', 'Data pasien gagal ditambahkan');
        }
    }

    public function edit(string $id): View
    {
        $user = User::findOrFail($id);

        return view('admin.datapasien.editp', compact('user'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'alamat' => 'required',
            'jenis_kelamin' => 'required',
            'umur' => 'required',
            'password' => '',
        ]);

        $user = User::findOrFail($id);

        if($request->password === NULL){
            $request->password = $user->password;
        }else{
            $request->password = bcrypt($request->password);
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'jenis_kelamin' => $request->jenis_kelamin,
            'umur' => $request->umur,
            'alamat'=> $request->alamat,
            'password' => $request->password
        ]);

        return redirect()->route('datapasien.index')->with(['success' => 'Data berhasil diubah']);
    }

    public function destroy($id): RedirectResponse
    {
        $user = User::findOrFail($id);

        $user->delete();

        return redirect()->route('datapasien.index')->with(['success' => 'Data berhasil dihapus']);
    }
}
