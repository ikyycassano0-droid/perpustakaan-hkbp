<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        $data = Location::latest()->get();
        return view('admin.page.location', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        Location::create([
            'name' => $request->name
        ]);

        return back()->with('success', 'Location berhasil ditambahkan');
    }

    // AJAX
    public function storeAjax(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $data = Location::create([
            'name' => $request->name
        ]);

        return response()->json($data);
    }

    public function update(Request $request, Location $location)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $location->update([
            'name' => $request->name
        ]);

        return back()->with('success', 'Location berhasil diupdate');
    }

    public function destroy(Location $location)
    {
        $location->delete();

        return back()->with('success', 'Location berhasil dihapus');
    }

    // DELETE LAST
    public function deleteLast()
    {
        $data = Location::latest()->first();

        if ($data) {
            $data->delete();
        }

        return response()->json([
            'success' => true
        ]);
    }
}