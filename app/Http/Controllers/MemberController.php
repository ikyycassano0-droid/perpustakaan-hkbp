<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;

class MemberController extends Controller
{
    public function index()
    {
        $members = User::whereIn('role_id', [2,3])->get();
        return view('admin.page.membership.index', compact('members'));
    }
    public function create()
    {
        $roles = Role::where('name', '!=', 'Admin')->get(); // ambil selain admin
        return view('admin.page.membership.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'npm' => 'required|unique:users,npm',
            'password' => 'required|min:6|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);

        User::create([
            'role_id' => $request->role_id,
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