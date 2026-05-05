<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Archive;
use Illuminate\Support\Facades\Auth;

class ArchiveController extends Controller
{
    public function indexPanduan()
    {
        $data = Archive::active()
            ->ordered()
            ->with('activeFiles')
            ->get();

        return view('user.page.panduan', compact('data'));
    }

    public function indexPanduanGuest()
    {
        $data = Archive::active()
            ->ordered()
            ->with('activeFiles')
            ->get();

        return view('guest.page.panduan', compact('data'));
    }

    public function index(Request $request)
    {
        $data = Archive::orderBy('category')
            ->orderBy('sequence')
            ->get()
            ->groupBy('category');

        // mode edit (jika ada ?edit=id)
        $editData = null;
        if ($request->edit) {
            $editData = Archive::find($request->edit);
        }

        return view('admin.page.panduan', compact('data', 'editData'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'category' => 'required|string',
            'sequence' => 'required|integer|min:1',
            'icon' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        // geser sequence
        Archive::where('category', $request->category)
            ->where('sequence', '>=', $request->sequence)
            ->increment('sequence');

        Archive::create([
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'icon' => $request->icon,
            'sequence' => $request->sequence,
            'active' => 1,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('admin.panduan.index')
        ->with('success', 'Panduan berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $archive = Archive::findOrFail($id);

        // VALIDASI OPTIONAL
        $request->validate([
            'title' => 'nullable|string',
            'category' => 'nullable|string',
            'sequence' => 'nullable|integer|min:1',
            'icon' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        if ($request->filled('sequence')) {

            $oldSequence = $archive->sequence;
            $newSequence = $request->sequence;

            if ($newSequence != $oldSequence) {

                if ($newSequence > $oldSequence) {
                    Archive::where('category', $archive->category)
                        ->whereBetween('sequence', [$oldSequence + 1, $newSequence])
                        ->decrement('sequence');
                } else {
                    Archive::where('category', $archive->category)
                        ->whereBetween('sequence', [$newSequence, $oldSequence - 1])
                        ->increment('sequence');
                }

                $archive->sequence = $newSequence;
            }
        }

        $data = array_filter([
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'icon' => $request->icon,
            'sequence' => $archive->sequence,
            'updated_by' => Auth::id(),
        ], function ($value) {
            return !is_null($value) && $value !== '';
        });

        $archive->update($data);

        return redirect()->route('archive.index')
            ->with('success', 'Panduan berhasil diupdate');
    }

    public function destroy($id)
    {
        Archive::destroy($id);

        return redirect()->route('archive.index')
            ->with('success', 'Data berhasil dihapus');
    }
}