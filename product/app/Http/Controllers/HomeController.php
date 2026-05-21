<?php

namespace App\Http\Controllers;

use App\Models\Home;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $homes = Home::all();
        return view('user.page.home', compact('homes'));
    }

    public function index_user()
    {
        $homes = Home::with('additionalSections')->latest()->first();

        $berita_terbaru = News::latest()->limit(4)-> get();

        if (!$homes) {
            // Jika tidak ada data About, kirim $about null ke view
            return view('user.page.home', [
                'about' => null,
                'berita_terbaru' => $berita_terbaru
            ]);
        }
        
        return view('user.page.home', compact('homes', 'berita_terbaru'));
    }

        public function admin()
    {
        $homes = Home::all();
        return view('admin.page.home', compact('homes'));
    }

        public function dosen()
    {
       $homes = Home::with('additionalSections')->latest()->first();

        $berita_terbaru = News::latest()->limit(4)-> get();

        if (!$homes) {
            // Jika tidak ada data About, kirim $about null ke view
            return view('dosen.page.home', [
                'about' => null,
                'berita_terbaru' => $berita_terbaru
            ]);
        }
        
        return view('dosen.page.home', compact('homes', 'berita_terbaru'));
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
        $validated = $request->validate([
            'judul_galeri' => 'required|string|max:255',
            'gambar_galeri' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('gambar_galeri')) {
            $file = $request->file('gambar_galeri');
            // Buat nama file unik dan sanitasi
            $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $path = $file->storeAs('galeri', $filename, 'public');
        }

        Gallery::create([
            'user_id' => user_id(),
            'judul_galeri' => $validated['judul_galeri'],
            'gambar_galeri' => $path
        ]);

        return redirect()->route('galleries.index')->with('success', 'Data galeri berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Home $home)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Home $home)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Home $home)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Home $home)
    {
        //
    }
}
