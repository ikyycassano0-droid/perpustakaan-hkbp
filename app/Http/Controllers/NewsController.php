<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    // ================= ADMIN =================
    public function index()
    {
        $berita = News::published()->latest()->paginate(6);
        return view('guest.page.berita', compact('berita'));
    }
    public function index_admin()
    {
        $berita = News::orderBy('created_at','desc')->get();
        return view('admin.page.berita', compact('berita'));
    }

    // ================= STORE =================
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'status' => 'required|in:draft,publish',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = $request->hasFile('image')
            ? $request->file('image')->store('berita', 'public')
            : null;

        News::create([
            'title' => $request->title,
            'content' => $request->content,
            'image' => $imagePath,
            'status' => $request->status, // penting
            'created_by' => session('user_id'),
        ]);

        return back()->with('success', 'Berita berhasil ditambahkan');
    }

    // ================= UPDATE =================
    public function update(Request $request, News $news)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'status' => 'required|in:draft,publish',
        ]);

        $data = [
            'title' => $request->title,
            'content' => $request->content,
            'status' => $request->status,
            'updated_by' => session('user_id'),
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('berita', 'public');
        }

        $news->update($data);

        return back()->with('success', 'Berita berhasil diupdate');
    }
    public function show($id)
    {
        $berita = News::where('id', $id)
            ->where('status', 'publish')
            ->firstOrFail();

        return view('guest.page.berita_detail', compact('berita'));
    }

    // ================= DELETE =================
    public function destroy(News $news)
    {
        if ($news->image) {
            \Storage::disk('public')->delete($news->image);
        }

        $news->delete();

        return back()->with('success', 'Berita berhasil dihapus');
    }

    // ================= FRONTEND =================

}