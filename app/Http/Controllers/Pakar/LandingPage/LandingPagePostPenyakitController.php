<?php

namespace App\Http\Controllers\Pakar\LandingPage;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\LandingPage\LandingPagePostPenyakit;
use App\Models\Penyakit;

class LandingPagePostPenyakitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $post_penyakit = LandingPagePostPenyakit::with(['penyakit', 'user'])
        ->where('user_id', auth()->user()->id)
        ->get();
        $data_penyakit = Penyakit::all();

        return  view('pakar.artikel.penyakit.index', compact('post_penyakit', 'data_penyakit'));
    }

    public function LandingPagePostPenyakit()
    {
        $post_penyakit = LandingPagePostPenyakit::with(['penyakit', 'user'])->get();

        return  view('user.landingpage.landing', compact('post_penyakit'));
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
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'id_penyakit' => 'required',
            'title_post_penyakit' => 'required',
            'slug_post_penyakit' => 'nullable',
            'tags_post_penyakit' => 'required',
            'description_post_penyakit' => 'required',
            'video_post_penyakit' => 'nullable',
            'image_post_penyakit' => 'sometimes |image|mimes:jpeg,jpg,png',
        ],
        [
            'user_id.required' => 'User ID tidak boleh kosong.',
            'id_penyakit.required' => 'ID Penyakit tidak boleh kosong.',
            'title_post_penyakit.required' => 'Judul Post Penyakit tidak boleh kosong.',
            'slug_post_penyakit.required' => 'Slug Post Penyakit tidak boleh kosong.',
            'tags_post_penyakit.required' => 'Tags Post Penyakit tidak boleh kosong.',
            'description_post_penyakit.required' => 'Deskripsi Post Penyakit tidak boleh kosong.',
            'video_post_penyakit.required' => 'Video Post Penyakit tidak boleh kosong.',
            'image_post_penyakit.required' => 'Gambar Post Penyakit tidak boleh kosong.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Proses penyimpanan data jika validasi berhasil

        // Simpan data post penyakit ke database
        $postPenyakit = new LandingPagePostPenyakit();
        $postPenyakit->user_id = $request->user_id;
        $postPenyakit->id_penyakit = $request->id_penyakit;
        $postPenyakit->title_post_penyakit = $request->title_post_penyakit;
        $postPenyakit->slug_post_penyakit = Str::slug($request->title_post_penyakit).'-'.time();
        $postPenyakit->tags_post_penyakit = $request->tags_post_penyakit;
        $postPenyakit->description_post_penyakit = $request->description_post_penyakit;
        $postPenyakit->video_post_penyakit = $request->video_post_penyakit;

        // Simpan gambar dengan nama acak
        if ($request->hasFile('image_post_penyakit')) {
            $image = $request->file('image_post_penyakit');
            $extension = $image->getClientOriginalExtension();
            $fileName = Str::random(40) . '.' . $extension;
            $path = $request->file('image_post_penyakit')->storeAs('public/images', $fileName);
            $postPenyakit->image_post_penyakit = 'public/images/' . $fileName;
        }


        $postPenyakit->save();

        // Redirect atau tampilkan pesan sukses
        return back()->with('success', 'Post Penyakit berhasil disimpan');
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
        $validator = Validator::make(
            $request->all(),
            [
                'user_id' => 'required',
                'id_penyakit' => 'required',
                'title_post_penyakit' => 'required',
                'slug_post_penyakit' => 'nullable',
                'tags_post_penyakit' => 'required',
                'description_post_penyakit' => 'required',
                'video_post_penyakit' => 'nullable',
                'image_post_penyakit' => 'sometimes|image|mimes:jpeg,jpg,png',
            ],
            [
                'user_id.required' => 'User ID tidak boleh kosong.',
                'id_penyakit.required' => 'ID Penyakit tidak boleh kosong.',
                'title_post_penyakit.required' => 'Judul Post Penyakit tidak boleh kosong.',
                'slug_post_penyakit.required' => 'Slug Post Penyakit tidak boleh kosong.',
                'tags_post_penyakit.required' => 'Tags Post Penyakit tidak boleh kosong.',
                'description_post_penyakit.required' => 'Deskripsi Post Penyakit tidak boleh kosong.',
                'video_post_penyakit.required' => 'Video Post Penyakit tidak boleh kosong.',
                'image_post_penyakit.required' => 'Gambar Post Penyakit tidak boleh kosong.',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Proses update data jika validasi berhasil

        // Cari post penyakit berdasarkan ID
        $postPenyakit = LandingPagePostPenyakit::find($id);
        if (!$postPenyakit) {
            return back()->with('error', 'Post Penyakit tidak ditemukan');
        }

        // Update data post penyakit
        $postPenyakit->user_id = $request->user_id;
        $postPenyakit->id_penyakit = $request->id_penyakit;
        $postPenyakit->title_post_penyakit = $request->title_post_penyakit;
        $postPenyakit->slug_post_penyakit = Str::slug($request->title_post_penyakit) . '-' . time();
        $postPenyakit->tags_post_penyakit = $request->tags_post_penyakit;
        $postPenyakit->description_post_penyakit = $request->description_post_penyakit;
        $postPenyakit->video_post_penyakit = $request->video_post_penyakit;

        // Update gambar jika ada file yang diupload
        if ($request->hasFile('image_post_penyakit')) {
            $image = $request->file('image_post_penyakit');
            $extension = $image->getClientOriginalExtension();
            $fileName = Str::random(40) . '.' . $extension;
            $path = $request->file('image_post_penyakit')->storeAs('public/images', $fileName);
            $postPenyakit->image_post_penyakit = 'public/images/' . $fileName;
        }

        $postPenyakit->save();

        // Redirect atau tampilkan pesan sukses
        return back()->with('success', 'Post Penyakit berhasil diupdate');
    }

    public function destroy($id)
    {
        // Cari post penyakit berdasarkan ID
        $postPenyakit = LandingPagePostPenyakit::find($id);
        if (!$postPenyakit) {
            return back()->with('error', 'Post Penyakit tidak ditemukan');
        }

        // Hapus gambar terkait post penyakit jika ada
        if (!empty($postPenyakit->image_post_penyakit)) {
            Storage::delete($postPenyakit->image_post_penyakit);
        }

        // Hapus post penyakit dari database
        $postPenyakit->delete();

        // Redirect atau tampilkan pesan sukses
        return back()->with('success', 'Post Penyakit berhasil dihapus');
    }
}
