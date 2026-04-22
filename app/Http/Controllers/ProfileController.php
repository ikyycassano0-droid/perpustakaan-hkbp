<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $profiles = Profile::latest()->get();
        return view('admin.profiles.index', compact('profiles'));
    }

    public function create()
    {
        return view('admin.profiles.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'type' => 'required|in:struktur,tugas_fungsi,visi_misi,kerjasama',
            'sub_type' => 'required',
            'order' => 'nullable|integer'
        ];

        if ($request->type == 'struktur') {
            $rules['title'] = 'required';
            $rules['jabatan'] = 'required';
            $rules['image'] = 'nullable|image';
        }

        elseif ($request->type == 'tugas_fungsi') {
            $rules['title'] = 'required';
            $rules['description'] = 'required';
        }

        elseif ($request->type == 'visi_misi') {
            $rules['description'] = 'required';
        }

        elseif ($request->type == 'kerjasama') {
            $rules['title'] = 'required';
        }

        $request->validate($rules);

        // upload image
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('profiles', 'public');
        }

        Profile::create([
            'type' => $request->type,
            'sub_type' => $request->sub_type,
            'title' => $request->title,
            'description' => $request->description,
            'jabatan' => $request->jabatan,
            'icon' => $request->icon,
            'image' => $imagePath,
            'order' => $request->order ?? 0,
        ]);

        return redirect()->route('admin.profiles.index')
            ->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $profile = Profile::findOrFail($id);
        return view('admin.profiles.edit', compact('profile'));
    }

    public function update(Request $request, $id)
    {
        $profile = Profile::findOrFail($id);

        $rules = [
            'type' => 'required|in:struktur,tugas_fungsi,visi_misi,kerjasama',
            'sub_type' => 'required',
            'order' => 'nullable|integer'
        ];

        if ($request->type == 'struktur') {
            $rules['title'] = 'required';
            $rules['jabatan'] = 'required';
        }

        elseif ($request->type == 'tugas_fungsi') {
            $rules['title'] = 'required';
            $rules['description'] = 'required';
        }

        elseif ($request->type == 'visi_misi') {
            $rules['description'] = 'required';
        }

        elseif ($request->type == 'kerjasama') {
            $rules['title'] = 'required';
        }

        $request->validate($rules);

        // update image
        if ($request->hasFile('image')) {
            if ($profile->image) {
                Storage::disk('public')->delete($profile->image);
            }
            $profile->image = $request->file('image')->store('profiles', 'public');
        }

        $profile->update([
            'type' => $request->type,
            'sub_type' => $request->sub_type,
            'title' => $request->title,
            'description' => $request->description,
            'jabatan' => $request->jabatan,
            'icon' => $request->icon,
            'order' => $request->order ?? 0,
        ]);

        return redirect()->route('admin.profiles.index')
            ->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $profile = Profile::findOrFail($id);

        if ($profile->image) {
            Storage::disk('public')->delete($profile->image);
        }

        $profile->delete();

        return back()->with('success', 'Data berhasil dihapus');
    }
}