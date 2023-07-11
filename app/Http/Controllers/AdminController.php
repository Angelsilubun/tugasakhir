<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function index(): View
    {

        $user = User::where('role', 1)->get();

        return view('admin.dataadmin.indexa', compact('user'));
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'image' => 'sometimes|image|mimes:jpeg,jpg,png',
        ],
        [
            'name.required' => 'Name tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'password.required' => 'Password tidak boleh kosong',
            'image' => 'Gambar tidak boleh kosong',
        ]);

        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        // Proses penyimpanan data jika validasi berhasil

        // Simpan data post penyakit ke database
        $admin = new User();
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = bcrypt($request->password);
        $admin->role = '1';

        // Simpan gambar dengan nama acak
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $fileName = Str::random(40) . '.' . $extension;
            $path = $request->file('image')->storeAs('public/admin', $fileName);
            $admin->image = 'public/admin/' . $fileName;
        }

        $admin->save();

        return back()->with('success', 'Data admin berhasil disimpan');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'password' => '',
            'image' => 'sometimes|image|mimes:jpeg,jpg,png',
        ],
        [
            'name.required' => 'Name tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'image' => 'Gambar tidak boleh kosong',
        ]);

        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        // Proses update data jika validasi berhasil

        // Cari post penyakit berdasarkan ID
        $admin = User::find($id);
        if (!$admin) {
            return back()->with('error', 'Data admin tidak ditemukan');
        }

        if($request->password === NULL){
                    $request->password = $admin->password;
                }else{
                    $request->password = bcrypt($request->password);
                }
        
                $admin->name = $request->name;
                $admin->email = $request->email;
                $admin->password = $request->password;

                // Update gambar jika ada file yang diupload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $fileName = Str::random(40) . '.' . $extension;
            $path = $request->file('image')->storeAs('public/admin', $fileName);
            $admin->image = 'public/admin/' . $fileName;
        }

        $admin->save();

        // Redirect atau tampilkan pesan sukses
        return back()->with('success', 'Data admin berhasil diupdate');
    }

    public function destroy($id)
    {
        $admin = User::find($id);
        if (!$admin) {
            return back()->with('error', 'Data admin tidak ditemukan');
        }

        // Hapus gambar terkait post penyakit jika ada
        if (!empty($admin->image)) {
            Storage::delete($admin->image);
        }

        // Hapus post penyakit dari database
        $admin->delete();

        // Redirect atau tampilkan pesan sukses
        return back()->with('success', 'Data admin berhasil dihapus');
    }
}
