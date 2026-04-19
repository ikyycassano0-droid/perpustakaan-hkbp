<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Archive;

class ArchiveController extends Controller
{
    // 🔥 USER: tampil berdasarkan category
    public function showByCategory($category)
    {
        // mapping category → view
        $viewMap = [
            'pinjam_buku'   => 'guest.page.Layanan.pinbal',
            'upload_ta'     => 'guest.page.Layanan.upload_ta',
            'waktu_layanan' => 'guest.page.Layanan.waktu_layanan',
        ];

        // validasi category
        if (!array_key_exists($category, $viewMap)) {
            abort(404);
        }

        $data = Archive::where('category', $category)->get();

        return view($viewMap[$category], compact('data', 'category'));
    }

    
    public function index()
    {
        $data = Archive::orderBy('sequence')->get()->groupBy('category');

        return view('admin.page.layanan', compact('data'));
    }
    
    public function indexLayananGuest($category)
    {
        $viewMap = [
            'pinjam_buku'   => 'guest.page.Layanan.pinbal',
            'upload_ta'     => 'guest.page.Layanan.upload_ta',
            'waktu_layanan' => 'guest.page.Layanan.waktu_layanan',
        ];

        if (!array_key_exists($category, $viewMap)) {
            abort(404);
        }

        // 🔥 INI YANG PENTING
        $data = Archive::where('category', $category)
                    ->orderBy('sequence') // WAJIB
                    ->get();

        return view($viewMap[$category], compact('data', 'category'));
    }
    public function create()
    {
        return view('admin.archive.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'category' => 'required',
            'sequence' => 'required|integer|min:1'
        ]);

        // 🔥 geser data lain ke bawah
        Archive::where('category', $request->category)
            ->where('sequence', '>=', $request->sequence)
            ->increment('sequence');

        // simpan data baru
        Archive::create([
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'sequence' => $request->sequence,
            'active' => 1, // 🔥 TAMBAHKAN INI
        ]);

        return back()->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = Archive::findOrFail($id);
        return view('admin.archive.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $archive = Archive::findOrFail($id);

        $oldSequence = $archive->sequence;
        $newSequence = $request->sequence;

        // kalau sequence diubah
        if ($newSequence && $newSequence != $oldSequence) {

            if ($newSequence > $oldSequence) {
                // geser ke atas (turun)
                Archive::where('category', $archive->category)
                    ->whereBetween('sequence', [$oldSequence + 1, $newSequence])
                    ->decrement('sequence');
            } else {
                // geser ke bawah (naik)
                Archive::where('category', $archive->category)
                    ->whereBetween('sequence', [$newSequence, $oldSequence - 1])
                    ->increment('sequence');
            }

            $archive->sequence = $newSequence;
        }

        // update field lain (partial update tetap jalan)
        $data = array_filter($request->only(['title','description','category']), function($v){
            return $v !== null && $v !== '';
        });

        $archive->update($data);

        return back()->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        Archive::destroy($id);
        return back();
    }

    public function byCategory($category)
    {
        $data = Archive::where('category', $category)->get();

        return view('admin.page.layanan', compact('data', 'category'));
    }
}