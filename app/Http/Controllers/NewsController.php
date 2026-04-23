<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    // ================= GUEST =================
    public function index(Request $request)
    {
        return $this->baseListing($request, 'guest.page.berita');
    }

    // ================= USER =================
    public function indexUser(Request $request)
    {
        return $this->baseListing($request, 'user.page.berita');
    }

    // ================= SHARED LISTING =================
    private function baseListing(Request $request, $view)
    {
        $search   = $request->search;
        $category = $request->category;

        $query = News::published();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                  ->orWhere('excerpt', 'like', "%$search%");
            });
        }

        if ($category && $category !== 'all') {
            $query->where('category', $category);
        }

        $featured = (clone $query)
            ->where('is_featured', true)
            ->latest()
            ->first();

        $berita = (clone $query)
            ->when($featured, function ($q) use ($featured) {
                $q->where('id', '!=', $featured->id);
            })
            ->latest()
            ->paginate(6);

        return view($view, compact('berita', 'featured'));
    }

    // ================= DETAIL (FIX FINAL ANTI 404) =================
    public function show($identifier)
    {
        $berita = News::published()
            ->where('slug', $identifier)
            ->orWhere('id', $identifier)
            ->firstOrFail();

        $related = News::published()
            ->where('id', '!=', $berita->id)
            ->latest()
            ->take(3)
            ->get();

        return view('guest.page.berita_detail', compact('berita', 'related'));
    }

    // ================= ADMIN =================
    public function index_admin()
    {
        $berita = News::latest()->get();
        return view('admin.page.berita', compact('berita'));
    }

    // ================= STORE =================
    public function store(Request $request)
    {
        $request->validate([
            'title'    => 'required',
            'content'  => 'required',
            'category' => 'required',
            'status'   => 'required|in:draft,publish',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = $request->file('image')
            ? $request->file('image')->store('berita', 'public')
            : null;

        News::create([
            'title'       => $request->title,

            // 🔥 FIX: slug unik (biar tidak bentrok)
            'slug'        => Str::slug($request->title) . '-' . time(),

            'excerpt'     => $request->excerpt,
            'content'     => $request->content,
            'image'       => $imagePath,
            'category'    => $request->category,
            'is_featured' => $request->boolean('is_featured'),
            'status'      => $request->status,
            'active'      => true,
            'created_by'  => session('user_id'),
        ]);

        return back()->with('success', 'Berita berhasil ditambahkan');
    }

    // ================= UPDATE =================
    public function update(Request $request, News $news)
    {
        $request->validate([
            'title'    => 'required',
            'content'  => 'required',
            'category' => 'required',
            'status'   => 'required|in:draft,publish',
        ]);

        $data = [
            'title'       => $request->title,

            // 🔥 FIX SLUG
            'slug'        => Str::slug($request->title) . '-' . time(),

            'excerpt'     => $request->excerpt,
            'content'     => $request->content,
            'category'    => $request->category,
            'is_featured' => $request->boolean('is_featured'),
            'status'      => $request->status,
            'active'      => $request->boolean('active'),
            'updated_by'  => session('user_id'),
        ];

        if ($request->file('image')) {
            if ($news->image) {
                Storage::disk('public')->delete($news->image);
            }

            $data['image'] = $request->file('image')->store('berita', 'public');
        }

        $news->update($data);

        return back()->with('success', 'Berita berhasil diupdate');
    }

    // ================= DELETE =================
    public function destroy(News $news)
    {
        if ($news->image) {
            Storage::disk('public')->delete($news->image);
        }

        $news->delete();

        return back()->with('success', 'Berita berhasil dihapus');
    }
}