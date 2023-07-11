<?php

namespace App\Http\Controllers\LandingPage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\LandingPage\LandingPagePostPenyakit;

class LandingPageArtikelController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = LandingPagePostPenyakit::with(['penyakit', 'user']);

        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('title_post_penyakit', 'like', "%$search%")
                    ->orWhere('description_post_penyakit', 'like', "%$search%")
                    ->orWhereHas('penyakit', function($q) use ($search) {
                        $q->where('nama_penyakit', 'like', "%$search%");
                    })
                    ->orWhereHas('user', function($q) use ($search) {
                        $q->where('name', 'like', "%$search%");
                    });
            });
        }

        $data = [
            "post_penyakit" => $query->paginate(6),
            "search" => $search,
        ];

        return view("user.landingpage.artikel", $data);
    }
}
