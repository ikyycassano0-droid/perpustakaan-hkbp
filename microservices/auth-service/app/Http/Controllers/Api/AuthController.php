<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * LOGIN
     */
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'npm' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::where('npm', $request->npm)
                    ->where('active', true)
                    ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'NPM atau password salah'
            ], 401);
        }

        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'role_id' => $user->role_id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'npm' => $user->npm,
                    'nidn' => $user->nidn,
                    'role' => [
                        'id' => $user->role_id,
                        'name' => $user->role?->name
                    ],
                    'is_admin' => $user->isAdmin(),
                    'email_verified' => $user->hasVerifiedEmail()
                ],
                'token' => $token,
                'token_type' => 'Bearer'
            ]
        ], 200);
    }

    /**
     * LOGOUT
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil'
        ], 200);
    }

    /**
     * VALIDATE TOKEN
     */
    public function validateToken(Request $request): JsonResponse
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Token tidak valid'
            ], 401);
        }

        return response()->json([
            'success' => true,
            'message' => 'Token valid',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'role_id' => $user->role_id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'npm' => $user->npm,
                    'nidn' => $user->nidn,
                    'role' => [
                        'id' => $user->role_id,
                        'name' => $user->role?->name
                    ],
                    'is_admin' => $user->isAdmin(),
                    'email_verified' => $user->hasVerifiedEmail(),
                    'active' => $user->active
                ]
            ]
        ], 200);
    }

    /**
     * GET USER PROFILE
     */
    public function profile(Request $request): JsonResponse
    {
        $user = $request->user()->load('role');

        return response()->json([
            'success' => true,
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'role_id' => $user->role_id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'npm' => $user->npm,
                    'nidn' => $user->nidn,
                    'birth_date' => $user->birth_date,
                    'gender' => $user->gender,
                    'membership_type' => $user->membership_type,
                    'phone' => $user->phone,
                    'photo' => $user->photo,
                    'role' => [
                        'id' => $user->role_id,
                        'name' => $user->role?->name
                    ],
                    'is_admin' => $user->isAdmin(),
                    'email_verified' => $user->hasVerifiedEmail(),
                    'active' => $user->active,
                    'created_at' => $user->created_at,
                    'updated_at' => $user->updated_at
                ]
            ]
        ], 200);
    }

    /**
     * RESEND VERIFICATION EMAIL
     */
    public function resendVerification(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if ($user->hasVerifiedEmail()) {
            return response()->json([
                'success' => false,
                'message' => 'Email sudah diverifikasi'
            ], 400);
        }

        $user->sendEmailVerificationNotification();

        return response()->json([
            'success' => true,
            'message' => 'Link verifikasi telah dikirim ke email Anda'
        ], 200);
    }

    /**
     * REGISTER - User baru langsung verified
     */
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'role_id' => 'required|integer',
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'npm' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'role_id' => $request->role_id,
            'name' => $request->name,
            'email' => $request->email,
            'npm' => $request->npm,
            'password' => $request->password,
            'active' => true,
            'email_verified_at' => now(),
        ]);

        return response()->json(['success' => true, 'user_id' => $user->id], 201);
    }

    /**
     * UPDATE PROFILE (nama, dsb.)
     */
    public function updateProfile(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = $request->user();
        $user->name = $request->name;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diperbarui',
            'data' => ['name' => $user->name]
        ]);
    }

    /**
     * UPDATE PASSWORD
     */
    public function updatePassword(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = $request->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Password saat ini salah',
            ], 403);
        }

        $user->password = $request->new_password; // hashing via mutator di model
        $user->save();

        // Opsional: hapus token agar user login ulang
        // $user->tokens()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Password berhasil diubah',
        ]);
    }
}