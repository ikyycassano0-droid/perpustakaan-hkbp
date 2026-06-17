<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Archive;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\ArchiveFile;

class ArchiveController extends Controller
{
    public function indexPanduan()
{
    $data = Archive::active()
        ->ordered()
        ->with('activeFiles')
        ->paginate(6);

    return view('user.page.panduan', compact('data'));
}

    public function indexPanduanGuest()
    {
        $data = Archive::active()
            ->ordered()
            ->with('activeFiles')
            ->paginate(6);

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
            'files.*' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        Archive::where('category', $request->category)
            ->where('sequence', '>=', $request->sequence)
            ->increment('sequence');

        $archive = Archive::create([
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'icon' => $request->icon,
            'sequence' => $request->sequence,
            'active' => 1,
            'created_by' => user_id(),
        ]);

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {

                $path = $file->store('archives', 'public');

                ArchiveFile::create([
                    'archive_id' => $archive->id,
                    'file_name' => $file->getClientOriginalName(),
                    'file_url' => $path,
                    'file_type' => $file->getClientOriginalExtension(),
                    'file_size' => round($file->getSize() / 1024),
                    'published_at' => now(),
                    'active' => 1,
                    'created_by' => user_id(),
                ]);
            }
        }

        return redirect()->route('admin.panduan.index')
            ->with('success', 'Panduan berhasil ditambahkan');
    }

    /* =========================
    UPDATE (MULTI + REPLACE)
    ========================= */
    public function update(Request $request, $id)
    {
        $archive = Archive::findOrFail($id);

        $request->validate([
            'title' => 'nullable|string',
            'category' => 'nullable|string',
            'sequence' => 'nullable|integer|min:1',
            'new_files.*' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'replace_file_id' => 'nullable|integer',
        ]);

        // UPDATE DATA
        $archive->update(array_filter([
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'icon' => $request->icon,
            'updated_by' => user_id(),
        ]));

        if ($request->replace_file_id && $request->hasFile('replace_file')) {

            $oldFile = ArchiveFile::findOrFail($request->replace_file_id);

            // hapus file lama dari storage
            if (Storage::disk('public')->exists($oldFile->file_url)) {
                Storage::disk('public')->delete($oldFile->file_url);
            }

            $file = $request->file('replace_file');
            $path = $file->store('archives', 'public');

            // update record lama (replace, bukan create baru)
            $oldFile->update([
                'file_name' => $file->getClientOriginalName(),
                'file_url' => $path,
                'file_type' => $file->getClientOriginalExtension(),
                'file_size' => round($file->getSize() / 1024),
                'updated_by' => user_id(),
            ]);
        }

        if ($request->hasFile('new_files')) {
            foreach ($request->file('new_files') as $file) {

                $path = $file->store('archives', 'public');

                ArchiveFile::create([
                    'archive_id' => $archive->id,
                    'file_name' => $file->getClientOriginalName(),
                    'file_url' => $path,
                    'file_type' => $file->getClientOriginalExtension(),
                    'file_size' => round($file->getSize() / 1024),
                    'published_at' => now(),
                    'active' => 1,
                    'created_by' => user_id(),
                ]);
            }
        }

        return redirect()->route('admin.panduan.index')
            ->with('success', 'Panduan berhasil diupdate');
    }

    public function deleteFile($id)
    {
        $file = ArchiveFile::findOrFail($id);

        if (Storage::disk('public')->exists($file->file_url)) {
            Storage::disk('public')->delete($file->file_url);
        }

        $file->delete();

        return back()->with('success', 'File berhasil dihapus');
    }

    /* =========================
    DELETE ARCHIVE + FILE
    ========================= */
    public function destroy($id)
    {
        $archive = Archive::with('files')->findOrFail($id);

        foreach ($archive->files as $file) {
            if (Storage::disk('public')->exists($file->file_url)) {
                Storage::disk('public')->delete($file->file_url);
            }
        }

        ArchiveFile::where('archive_id', $id)->delete();
        $archive->delete();

        return redirect()->route('admin.panduan.index')
            ->with('success', 'Data berhasil dihapus');
    }
}
