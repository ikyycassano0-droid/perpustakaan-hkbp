<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use App\Jobs\SendVerificationEmailJob;
use Illuminate\Support\Facades\Http;

class MemberController extends Controller
{
    public function index()
    {
        $members = User::whereIn('role_id', [2, 3])->get();
        return view('admin.page.Membership.index', compact('members'));
    }

    public function create()
    {
        $roles = Role::where('name', '!=', 'Admin')->get();
        return view('admin.page.Membership.create', compact('roles'));
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
            'password' => $request->password, // auto hash dari model
        ]);

        try {
            Http::timeout(5)
                ->post(env('AUTH_SERVICE_URL', 'http://localhost:8003/api/v1') . '/auth/register', [
                    'role_id' => $request->role_id,
                    'name' => $request->name,
                    'email' => $request->email,
                    'npm' => $request->npm,
                    'password' => $request->password,
                ]);
        } catch (\Exception $e) {
            \Log::error('Gagal sinkron ke Auth Service: ' . $e->getMessage());
        }

        // kirim email verifikasi Laravel
        event(new Registered($user));

        return redirect()
            ->route('admin.members.index')
            ->with('success', 'Anggota berhasil ditambahkan & email verifikasi dikirim');
    }

    public function edit($id)
    {
        $member = User::findOrFail($id);
        $roles = Role::where('name', '!=', 'Admin')->get();

        return view('admin.page.Membership.edit', compact('member', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $member = User::findOrFail($id);
        $emailLama = $member->email; // Simpan email lama

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'npm' => 'required|unique:users,npm,' . $id,
            'role_id' => 'required|exists:roles,id',
            'phone' => 'nullable|regex:/^[0-9]+$/|min:10|max:15',
        ]);

        $member->role_id = $request->role_id;
        $member->name = $request->name;
        $member->email = $request->email;
        $member->npm = $request->npm;
        $member->nidn = $request->nidn;
        $member->birth_date = $request->birth_date;
        $member->gender = $request->gender;
        $member->membership_type = $request->membership_type;
        $member->phone = $request->phone;

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:8|confirmed']);
            $member->password = $request->password;
        }

        $member->save();

        // Sinkron ke Auth Service
        // Sinkron ke Auth Service
    try {
        $data = [
            'email' => $emailLama,
            'npm_lama' => $member->getOriginal('npm'),
            'name' => $request->name,
            'npm' => $request->npm,
        ];
        
        if ($request->email !== $emailLama) {
            $data['email_baru'] = $request->email;
        }
        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        Http::timeout(5)->post(
            env('AUTH_SERVICE_URL', 'http://localhost:8003/api/v1') . '/auth/admin-update',
            $data
        );
        } catch (\Exception $e) {
            \Log::error('Gagal sinkron ke Auth Service: ' . $e->getMessage());
        }

        return redirect()
            ->route('admin.members.index')
            ->with('success', 'Data anggota berhasil diupdate');
    }

    public function destroy($id)
    {
        $member = User::findOrFail($id);
        $member->delete();

        return redirect()
            ->route('admin.members.index')
            ->with('success', 'Data anggota berhasil dihapus');
    }

    public function resendVerification($id)
    {
        $member = User::findOrFail($id);

        // kalau sudah verified
        if ($member->hasVerifiedEmail()) {
            return back()->with('info', 'Email sudah diverifikasi.');
        }

        // refresh data biar tidak stale
        $member->refresh();

        // kirim via queue (background job)
        SendVerificationEmailJob::dispatch($member)
            ->delay(now()->addSeconds(2));

        return back()->with('success', 'Link verifikasi sedang dikirim (queue).');
    }
}
