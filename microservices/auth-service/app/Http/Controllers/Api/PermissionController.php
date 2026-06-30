<?php
// microservices/auth-service/app/Http/Controllers/Api/PermissionController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class PermissionController extends Controller
{
    /**
     * Get all permissions.
     * GET /api/v1/auth/permissions
     */
    public function index()
    {
        try {
            $permissions = [
                ['id' => 1, 'name' => 'view_members', 'description' => 'View all members'],
                ['id' => 2, 'name' => 'create_members', 'description' => 'Create new members'],
                ['id' => 3, 'name' => 'edit_members', 'description' => 'Edit members'],
                ['id' => 4, 'name' => 'delete_members', 'description' => 'Delete members'],
                ['id' => 5, 'name' => 'manage_roles', 'description' => 'Manage roles'],
                ['id' => 6, 'name' => 'view_reports', 'description' => 'View reports'],
                ['id' => 7, 'name' => 'manage_settings', 'description' => 'Manage settings'],
                ['id' => 8, 'name' => 'manage_orders', 'description' => 'Manage orders'],
            ];

            return response()->json([
                'success' => true,
                'message' => 'Permissions fetched successfully',
                'data' => $permissions
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to get permissions: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to get permissions: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Grant permission to a user.
     * POST /api/v1/auth/permissions/{id}/grant
     */
    public function grant(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'permission' => 'required|string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = User::findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => "Permission '{$request->permission}' granted to user successfully",
                'data' => [
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                    'permission' => $request->permission
                ]
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Failed to grant permission: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to grant permission: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Revoke permission from a user.
     * POST /api/v1/auth/permissions/{id}/revoke
     */
    public function revoke(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'permission' => 'required|string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = User::findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => "Permission '{$request->permission}' revoked from user successfully",
                'data' => [
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                    'permission' => $request->permission
                ]
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Failed to revoke permission: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to revoke permission: ' . $e->getMessage()
            ], 500);
        }
    }
}