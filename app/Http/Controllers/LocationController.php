<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    // ================= INDEX =================
    public function index()
    {
        $locations = Location::latest()->get();

        return view('admin.page.location', compact('locations'));
    }

    // ================= STORE =================
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:locations,name',
            'code' => 'nullable|string|max:50|unique:locations,code'
        ]);

        Location::create([
            'name' => $request->name,
            'code' => $request->code ?? strtoupper(substr($request->name, 0, 3)) . rand(100,999),
        ]);

        return back()->with('success', 'Location berhasil ditambahkan');
    }

    // ================= STORE AJAX =================
    public function storeAjax(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $location = Location::create([
            'name' => $request->name,
            'code' => strtoupper(substr($request->name, 0, 3)) . rand(100,999),
        ]);

        return response()->json([
            'id' => $location->id,
            'name' => $location->name
        ]);
    }

    // ================= UPDATE =================
    public function update(Request $request, Location $location)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:locations,name,' . $location->id,
            'code' => 'nullable|string|max:50|unique:locations,code,' . $location->id,
        ]);

        $location->update([
            'name' => $request->name,
            'code' => $request->code ?? $location->code,
        ]);

        return back()->with('success', 'Location berhasil diupdate');
    }

    // ================= DELETE =================
    public function destroy(Location $location)
    {
        // CEK RELASI
        if ($location->collections()->count() > 0) {
            return back()->with('error', 'Location masih digunakan oleh koleksi');
        }

        $location->delete();

        return back()->with('success', 'Location berhasil dihapus');
    }

    // ================= DELETE LAST (AJAX) =================
    public function deleteLast()
    {
        $location = Location::latest()->first();

        if (!$location) {
            return response()->json([
                'success' => false,
                'message' => 'Data kosong'
            ], 404);
        }

        // optional safety check (biar sama seperti destroy)
        if ($location->collections()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Location masih digunakan'
            ], 400);
        }

        $id = $location->id;

        $location->delete();

        return response()->json([
            'success' => true,
            'id' => $id,
            'name' => $location->name
        ]);
    }
}   