<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    public function index()
    {
        $members = User::where('role_id', 2)->get();
        return view('admin.page.membership.index', compact('members'));
    }

    public function create()
    {
        return view('admin.page.membership.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'npm' => 'required|unique:users,npm',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'role_id' => 2,
            'name' => $request->name,
            'npm' => $request->npm,
            'nidn' => $request->nidn,
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
            'membership_type' => $request->membership_type,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Anggota berhasil ditambahkan');
    }
}