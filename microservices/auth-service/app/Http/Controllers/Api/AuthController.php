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
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        // Validasi input
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

        // Cari user berdasarkan NPM dan status active
        $user = User::where('npm', $request->npm)
                    ->where('active', true)
                    ->first();

        // Cek password
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'NPM atau password salah'
            ], 401);
        }

        // Cek verifikasi email untuk non-admin
        if (!$user->isAdmin() && !$user->hasVerifiedEmail()) {
            return response()->json([
                'success' => false,
                'message' => 'Email belum diverifikasi. Silakan cek Gmail Anda.',
                'needs_verification' => true,
                'user_id' => $user->id
            ], 403);
        }

        // Generate token Sanctum
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
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        // Revoke token yang sedang digunakan
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil'
        ], 200);
    }

    /**
     * VALIDATE TOKEN
     * Digunakan oleh service lain untuk verifikasi token
     * 
     * @param Request $request
     * @return JsonResponse
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
     * 
     * @param Request $request
     * @return JsonResponse
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
     * 
     * @param Request $request
     * @return JsonResponse
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
}