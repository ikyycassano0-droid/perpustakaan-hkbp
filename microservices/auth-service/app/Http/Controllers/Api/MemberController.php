<?php
// microservices/auth-service/app/Http/Controllers/Api/MemberController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class MemberController extends Controller
{
    /**
     * Display a listing of members (API).
     * GET /api/v1/auth/members
     */
    public function index(Request $request)
    {
        try {
            $query = User::whereIn('role_id', [2, 3]); // Member & Dosen

            // Filter by search
            if ($request->has('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                      ->orWhere('email', 'LIKE', "%{$search}%")
                      ->orWhere('npm', 'LIKE', "%{$search}%")
                      ->orWhere('phone', 'LIKE', "%{$search}%");
                });
            }

            // Filter by role
            if ($request->has('role_id')) {
                $query->where('role_id', $request->role_id);
            }

            // Filter by verification status
            if ($request->has('verified')) {
                if ($request->verified === 'true') {
                    $query->whereNotNull('email_verified_at');
                } elseif ($request->verified === 'false') {
                    $query->whereNull('email_verified_at');
                }
            }

            $members = $query->orderBy('created_at', 'desc')
                            ->paginate($request->per_page ?? 20);

            // Add role name to each member
            $members->getCollection()->transform(function ($member) {
                $member->role_name = $member->role ? $member->role->name : null;
                return $member;
            });

            return response()->json([
                'success' => true,
                'message' => 'Members fetched successfully',
                'data' => $members
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to fetch members: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch members: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created member (API).
     * POST /api/v1/auth/members
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'npm' => 'required|string|unique:users,npm',
                'password' => 'required|string|min:6|confirmed',
                'role_id' => 'required|exists:roles,id',
                'phone' => 'nullable|string|regex:/^[0-9]+$/|min:10|max:15',
                'birth_date' => 'nullable|date',
                'gender' => 'nullable|in:L,P',
                'membership_type' => 'nullable|string',
                'nidn' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            // Create user
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

            // Kirim email verifikasi
            event(new Registered($user));

            return response()->json([
                'success' => true,
                'message' => 'Member created successfully. Verification email sent.',
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'npm' => $user->npm,
                    'role_id' => $user->role_id,
                    'role_name' => $user->role ? $user->role->name : null,
                    'created_at' => $user->created_at
                ]
            ], 201);

        } catch (\Exception $e) {
            Log::error('Failed to create member: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to create member: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified member (API).
     * GET /api/v1/auth/members/{id}
     */
    public function show($id)
    {
        try {
            $member = User::with('role')->whereIn('role_id', [2, 3])->findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => 'Member fetched successfully',
                'data' => [
                    'id' => $member->id,
                    'role_id' => $member->role_id,
                    'role_name' => $member->role ? $member->role->name : null,
                    'name' => $member->name,
                    'email' => $member->email,
                    'npm' => $member->npm,
                    'nidn' => $member->nidn,
                    'birth_date' => $member->birth_date,
                    'gender' => $member->gender,
                    'membership_type' => $member->membership_type,
                    'phone' => $member->phone,
                    'photo' => $member->photo ? url('storage/' . $member->photo) : null,
                    'email_verified_at' => $member->email_verified_at,
                    'is_verified' => $member->hasVerifiedEmail(),
                    'created_at' => $member->created_at,
                    'updated_at' => $member->updated_at
                ]
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Member not found'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Failed to fetch member: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch member: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified member (API).
     * PUT /api/v1/auth/members/{id}
     */
    public function update(Request $request, $id)
    {
        try {
            $member = User::whereIn('role_id', [2, 3])->findOrFail($id);

            $validator = Validator::make($request->all(), [
                'name' => 'sometimes|string|max:255',
                'email' => 'sometimes|email|unique:users,email,' . $id,
                'npm' => 'sometimes|string|unique:users,npm,' . $id,
                'password' => 'sometimes|string|min:6|confirmed',
                'role_id' => 'sometimes|exists:roles,id',
                'phone' => 'nullable|string|regex:/^[0-9]+$/|min:10|max:15',
                'birth_date' => 'nullable|date',
                'gender' => 'nullable|in:L,P',
                'membership_type' => 'nullable|string',
                'nidn' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            // Update data
            $data = $request->except(['password']);
            
            if ($request->has('password')) {
                $data['password'] = $request->password;
            }

            $member->update($data);

            // Refresh to get updated data
            $member->refresh();

            return response()->json([
                'success' => true,
                'message' => 'Member updated successfully',
                'data' => [
                    'id' => $member->id,
                    'role_id' => $member->role_id,
                    'role_name' => $member->role ? $member->role->name : null,
                    'name' => $member->name,
                    'email' => $member->email,
                    'npm' => $member->npm,
                    'phone' => $member->phone,
                    'updated_at' => $member->updated_at
                ]
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Member not found'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Failed to update member: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update member: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified member (API).
     * DELETE /api/v1/auth/members/{id}
     */
    public function destroy($id)
    {
        try {
            $member = User::whereIn('role_id', [2, 3])->findOrFail($id);

            // Check if member has active borrowings
            if (method_exists($member, 'orders') && $member->orders()->where('status', 'borrowed')->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete member with active borrowings'
                ], 400);
            }

            // Delete photo if exists
            if ($member->photo) {
                Storage::disk('public')->delete($member->photo);
            }

            $member->delete();

            return response()->json([
                'success' => true,
                'message' => 'Member deleted successfully'
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Member not found'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Failed to delete member: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete member: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Resend verification email (API).
     * POST /api/v1/auth/members/{id}/resend-verification
     */
    public function resendVerification($id)
    {
        try {
            $member = User::whereIn('role_id', [2, 3])->findOrFail($id);

            if ($member->hasVerifiedEmail()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email already verified'
                ], 400);
            }

            // Kirim ulang verifikasi
            $member->sendEmailVerificationNotification();

            return response()->json([
                'success' => true,
                'message' => 'Verification email sent successfully'
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Member not found'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Failed to resend verification: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to resend verification: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete member photo (API).
     * DELETE /api/v1/auth/members/{id}/photo
     */
    public function deletePhoto($id)
    {
        try {
            $member = User::whereIn('role_id', [2, 3])->findOrFail($id);

            if (!$member->photo) {
                return response()->json([
                    'success' => false,
                    'message' => 'No photo found'
                ], 404);
            }

            Storage::disk('public')->delete($member->photo);
            $member->photo = null;
            $member->save();

            return response()->json([
                'success' => true,
                'message' => 'Member photo deleted successfully'
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Member not found'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Failed to delete photo: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete photo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Toggle member status (verified/unverified) (API).
     * POST /api/v1/auth/members/{id}/toggle-verified
     */
    public function toggleVerified($id)
    {
        try {
            $member = User::whereIn('role_id', [2, 3])->findOrFail($id);

            if ($member->hasVerifiedEmail()) {
                $member->email_verified_at = null;
                $message = 'Member unverified';
            } else {
                $member->email_verified_at = now();
                $message = 'Member verified';
            }
            
            $member->save();

            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => [
                    'id' => $member->id,
                    'name' => $member->name,
                    'email' => $member->email,
                    'is_verified' => $member->hasVerifiedEmail()
                ]
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Member not found'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Failed to toggle verification: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to toggle verification: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get member statistics (API).
     * GET /api/v1/auth/members/stats
     */
    public function stats()
    {
        try {
            $total = User::whereIn('role_id', [2, 3])->count();
            $verified = User::whereIn('role_id', [2, 3])
                            ->whereNotNull('email_verified_at')
                            ->count();
            $unverified = User::whereIn('role_id', [2, 3])
                              ->whereNull('email_verified_at')
                              ->count();
            $today = User::whereIn('role_id', [2, 3])
                         ->whereDate('created_at', now()->toDateString())
                         ->count();
            $thisWeek = User::whereIn('role_id', [2, 3])
                            ->whereBetween('created_at', [
                                now()->startOfWeek(),
                                now()->endOfWeek()
                            ])
                            ->count();

            // Group by role
            $byRole = User::whereIn('role_id', [2, 3])
                          ->with('role')
                          ->get()
                          ->groupBy('role.name')
                          ->map(function ($group) {
                              return $group->count();
                          });

            return response()->json([
                'success' => true,
                'message' => 'Member statistics fetched successfully',
                'data' => [
                    'total' => $total,
                    'verified' => $verified,
                    'unverified' => $unverified,
                    'verification_rate' => $total > 0 
                        ? round(($verified / $total) * 100, 2) 
                        : 0,
                    'new_today' => $today,
                    'new_this_week' => $thisWeek,
                    'by_role' => $byRole,
                    'last_updated' => now()->toIso8601String()
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to get stats: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to get stats: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export members data (API).
     * GET /api/v1/auth/members/export
     */
    public function export(Request $request)
    {
        try {
            $format = $request->format ?? 'json';
            
            $members = User::whereIn('role_id', [2, 3])
                           ->with('role')
                           ->get()
                           ->map(function ($member) {
                               return [
                                   'id' => $member->id,
                                   'name' => $member->name,
                                   'email' => $member->email,
                                   'npm' => $member->npm,
                                   'role' => $member->role ? $member->role->name : null,
                                   'phone' => $member->phone,
                                   'is_verified' => $member->hasVerifiedEmail(),
                                   'created_at' => $member->created_at->format('Y-m-d H:i:s')
                               ];
                           });

            if ($format === 'json') {
                return response()->json([
                    'success' => true,
                    'message' => 'Members exported successfully',
                    'data' => $members,
                    'total' => $members->count()
                ]);
            }

            // Untuk format CSV/Excel nanti bisa ditambahkan
            return response()->json([
                'success' => false,
                'message' => 'Format not supported yet'
            ], 400);

        } catch (\Exception $e) {
            Log::error('Failed to export members: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to export members: ' . $e->getMessage()
            ], 500);
        }
    }
}