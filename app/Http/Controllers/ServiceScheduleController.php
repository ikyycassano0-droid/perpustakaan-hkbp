<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceSchedule;

class ServiceScheduleController extends Controller
{
    // ================================
    // 🔹 GUEST (HALAMAN UTAMA KAMU)
    // ================================
    public function indexGuest()
    {
        $schedules = ServiceSchedule::ordered()->get();

        return view('guest.page.Layanan.waktu_layanan', compact('schedules'));
    }

        public function indexUser()
    {
        $schedules = ServiceSchedule::ordered()->get();

        return view('guest.page.Layanan.waktu_layanan', compact('schedules'));
    }

    // ================================
    // 🔹 ADMIN LIST
    // ================================
    public function index()
    {
        $schedules = ServiceSchedule::ordered()->get();

        return view('admin.page.waktu_layanan', compact('schedules'));
    }

    // ================================
    // 🔹 STORE (TAMBAH DATA)
    // ================================
    public function store(Request $request)
    {
        $request->validate([
            'day_short' => 'required|max:5',
            'day_name' => 'required|max:20',
            'service_hours' => 'required',
            'status' => 'required',
            'status_color' => 'required',
            'order' => 'required|integer'
        ]);

        ServiceSchedule::create($request->all());

        return back()->with('success', 'Data berhasil ditambahkan');
    }

    // ================================
    // 🔹 UPDATE FULL (OPSIONAL)
    // ================================
    public function update(Request $request, $id)
    {
        $schedule = ServiceSchedule::findOrFail($id);

        $request->validate([
            'day_short' => 'required|max:5',
            'day_name' => 'required|max:20',
            'service_hours' => 'required',
            'status' => 'required',
            'status_color' => 'required',
            'order' => 'required|integer'
        ]);

        $schedule->update($request->all());

        return back()->with('success', 'Data berhasil diperbarui');
    }

    // ================================
    // 🔥 INLINE EDIT (1 KOLOM SAJA)
    // ================================
    public function updateField(Request $request, $id)
    {
        $request->validate([
            'field' => 'required|string',
            'value' => 'nullable|string'
        ]);

        $allowedFields = [
            'day_short',
            'day_name',
            'service_hours',
            'status',
            'status_color',
            'note',
            'order'
        ];

        if (!in_array($request->field, $allowedFields)) {
            return response()->json([
                'success' => false,
                'message' => 'Field tidak valid'
            ], 400);
        }

        $schedule = ServiceSchedule::findOrFail($id);

        // 🔥 hanya update 1 field
        $schedule->{$request->field} = $request->value;
        $schedule->save();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil update',
            'data' => $schedule
        ]);
    }

    // ================================
    // 🔹 DELETE
    // ================================
    public function destroy($id)
    {
        $schedule = ServiceSchedule::findOrFail($id);
        $schedule->delete();

        return back()->with('success', 'Data berhasil dihapus');
    }
}