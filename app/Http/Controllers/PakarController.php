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

class PakarController extends Controller
{
    public function index(): View
    {

        $user = User::where('role', 2)->get();

        return view('admin.datauser.index', compact('user'));
    }
    
    // public function store(Request $request): RedirectResponse
    // {
    //     $this->validate($request, [
    //         'name' => 'required',
    //         'email' => 'required',
    //         'password' => 'required',
    //         'image' => 'sometimes|image|mimes:jpeg,jpg,png|max:5000'
    //     ]
    // );
        
    //     if ($request->file("image")) {
            
    //         $data = $request->file("image")->store("profile_pakar");
    //     }

    //     $user = User::create([
    //         "name" => $request->name,
    //         "email" => $request->email,
    //         "password" => bcrypt($request->password),
    //         "image" => $data,
    //         "role" => "2",
    //     ]);

    //     return redirect()->route('datauser.index')->with(['success' => 'Data berhasil ditambahkan']);
        
    // }

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
        $pakar = new User();
        $pakar->name = $request->name;
        $pakar->email = $request->email;
        $pakar->password = bcrypt($request->password);
        $pakar->role = '2';

        // Simpan gambar dengan nama acak
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $fileName = Str::random(40) . '.' . $extension;
            $path = $request->file('image')->storeAs('public/pakar', $fileName);
            $pakar->image = 'public/pakar/' . $fileName;
        }

        $pakar->save();

        return back()->with('success', 'Data pakar berhasil disimpan');

    }

    // public function edit(string $id): View
    // {
    //     $user = User::findOrFail($id);

    //     return view('admin.datauser.editu', compact('user'));
    // }

    // public function update(Request $request, $id): RedirectResponse
    // {
    //     $this->validate($request, [
    //         'name' => 'required|min:5',
    //         'email' => 'required|min:10',
    //         'password' => '',
    //         'image' => 'image|mimes:jpeg,jpg,png|max:5000'
    //     ]);
        
    //     $user = User::findOrFail($id);

    //     if ($request->file("image")) {
    //         if ($request->gambarLama) {
    //             Storage::delete($request->gambarLama);
    //         }
            
    //         $data = $request->file("image")->store("profile_pakar");
    //     } else {
    //         $data = $user->image;
    //     }

    //     if($request->password === NULL){
    //         $request->password = $user->password;
    //     }else{
    //         $request->password = bcrypt($request->password);
    //     }

    //     User::where("id", $id)->update([
    //         "name" => $request->name,
    //         "email" => $request->email,
    //         "image" => $data,
    //         "password" => $request->password
    //     ]);


    //     return redirect()->route('datauser.index')->with(['success' => 'Data berhasil diubah']);
    // }

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
        $pakar = User::find($id);
        if (!$pakar) {
            return back()->with('error', 'Data pakar tidak ditemukan');
        }

        if($request->password === NULL){
                    $request->password = $pakar->password;
                }else{
                    $request->password = bcrypt($request->password);
                }
        
                $pakar->name = $request->name;
                $pakar->email = $request->email;
                $pakar->password = $request->password;
                // $pakar->role = '2';

                // Update gambar jika ada file yang diupload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $fileName = Str::random(40) . '.' . $extension;
            $path = $request->file('image')->storeAs('public/pakar', $fileName);
            $pakar->image = 'public/pakar/' . $fileName;
        }

        $pakar->save();

        // Redirect atau tampilkan pesan sukses
        return back()->with('success', 'Data pakar berhasil diupdate');

    }

    // public function destroy(Request $request, $id): RedirectResponse
    // {
    //     $user = User::findOrFail($id);

    //     // Storage::delete('public/profile_pakar/'.$user->image);
    //     Storage::delete($request->gambarLama);
    //     $user->delete();

    //     return redirect()->route('datauser.index')->with(['success', 'Data berhasil dihapus']);
    // }

    public function destroy($id)
    {
        $pakar = User::find($id);
        if (!$pakar) {
            return back()->with('error', 'Data pakar tidak ditemukan');
        }

        // Hapus gambar terkait post penyakit jika ada
        if (!empty($pakar->image)) {
            Storage::delete($pakar->image);
        }

        // Hapus post penyakit dari database
        $pakar->delete();

        // Redirect atau tampilkan pesan sukses
        return back()->with('success', 'Data pakar berhasil dihapus');
    }
}
