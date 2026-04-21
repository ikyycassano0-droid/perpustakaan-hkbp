<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use Illuminate\Auth\Events\Registered;

class MemberController extends Controller
{
    public function index()
    {
        $members = User::whereIn('role_id', [2,3])->get();
        return view('admin.page.membership.index', compact('members'));
    }

    public function create()
    {
        $roles = Role::where('name', '!=', 'Admin')->get();
        return view('admin.page.membership.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email', 
            'npm' => 'required|unique:users,npm',
            'password' => 'required|min:6|confirmed',
            'role_id' => 'required|exists:roles,id',

            'phone' => 'nullable|regex:/^[0-9]+$/|min:10|max:15',
        ]);

        
        $user = User::create([
            'role_id' => $request->role_id,
            'name' => $request->name,
            'email' => $request->email, 
            'npm' => $request->npm,
            'nidn' => $request->nidn,
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
            'membership_type' => $request->membership_type,
            'phone' => $request->phone,
            'password' => $request->password,
        ]);

        
        event(new Registered($user));

        return redirect()->route('admin.members.index')
            ->with('success', 'Data anggota berhasil ditambahkan & email verifikasi dikirim');
    }

    public function edit($id)
    {
        $member = User::findOrFail($id);
        $roles = Role::where('name', '!=', 'Admin')->get();

        return view('admin.page.membership.edit', compact('member', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $member = User::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'npm' => 'required|unique:users,npm,' . $id,
            'role_id' => 'required|exists:roles,id',

            'phone' => 'nullable|regex:/^[0-9]+$/|min:10|max:15',
        ]);

        $member->update([
            'role_id' => $request->role_id,
            'name' => $request->name,
            'npm' => $request->npm,
            'nidn' => $request->nidn,
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
            'membership_type' => $request->membership_type,
            'phone' => $request->phone,
        ]);

        // password optional update
        if ($request->password) {
            $request->validate([
                'password' => 'min:6|confirmed',
            ]);

            $member->password = $request->password;
            $member->save();
        }

        return redirect()->route('admin.members.index')->with('success', 'Data anggota berhasil diupdate');
    }

    public function destroy($id)
    {
        $member = User::findOrFail($id);
        $member->delete();

        return redirect()->route('admin.members.index')->with('success', 'Data anggota berhasil dihapus');
    }

    public function resendVerification($id)
    {
        $member = User::findOrFail($id);
        

        if ($member->hasVerifiedEmail()) {
            return back()->with('info', 'Email sudah diverifikasi.');
        }

        $member->sendEmailVerificationNotification();

        return back()->with('success', 'Link verifikasi berhasil dikirim ulang.');
    }
}