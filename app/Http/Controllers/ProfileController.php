<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
    * Display a listing of the resource.
    */
    public function index()
    {
        $data = [   
            "profil_admin" => User::first()
        ];
        
        return view('admin.profile.index_profile', $data);
        
    }
    
    /**
    * Show the form for creating a new resource.
    */
    public function create()
    {
        //
    }
    
    /**
    * Store a newly created resource in storage.
    */
    public function store(Request $request)
    {
        //
    }
    
    /**
    * Display the specified resource.
    */
    public function show(string $id)
    {
        //
    }
    
    /**
    * Show the form for editing the specified resource.
    */
    public function edit(string $id)
    {
        //
    }
    
    /**
    * Update the specified resource in storage.
    */
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
    /**
    * Remove the specified resource from storage.
    */
    public function destroy(string $id)
    {
        //
    }
}
