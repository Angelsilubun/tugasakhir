<?php

namespace App\Http\Controllers;

use App\Models\Petunjuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LandingpageController extends Controller
{
    public function index()
    {
        $data = [
            "petunjuk" => Petunjuk::all(),
        ];


        return view("user.landingpage.petunjuk", $data);
    }

    // public function show(string $id)
    // {
    //     $isi_tentang = Tentang::findOrFail(decrypt($id));
    //     return view("user.landingpage.isi_tentang", compact('isi_tentang') );
    // }

}
