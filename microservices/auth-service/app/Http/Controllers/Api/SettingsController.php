<?php
// microservices/auth-service/app/Http/Controllers/Api/SettingsController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class SettingsController extends Controller
{
    /**
     * Get all settings.
     * GET /api/v1/auth/settings
     */
    public function index()
    {
        try {
            $settings = [
                'app' => [
                    'name' => config('app.name'),
                    'environment' => app()->environment(),
                    'timezone' => config('app.timezone'),
                    'locale' => app()->getLocale(),
                ],
                'library' => [
                    'max_borrow_days' => 7,
                    'max_borrow_books' => 3,
                    'fine_per_day' => 5000,
                    'grace_period' => 2,
                    'max_reservations' => 2,
                ],
                'auth' => [
                    'registration_enabled' => true,
                    'email_verification' => true,
                    'password_min_length' => 8,
                    'session_timeout' => 60,
                ],
                'notifications' => [
                    'email_enabled' => true,
                    'sms_enabled' => false,
                ]
            ];

            return response()->json([
                'success' => true,
                'message' => 'Settings fetched successfully',
                'data' => $settings
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to get settings: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to get settings: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update settings.
     * PUT /api/v1/auth/settings
     */
    public function update(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'max_borrow_days' => 'sometimes|integer|min:1|max:30',
                'max_borrow_books' => 'sometimes|integer|min:1|max:10',
                'fine_per_day' => 'sometimes|integer|min:0',
                'grace_period' => 'sometimes|integer|min:0|max:7',
                'registration_enabled' => 'sometimes|boolean',
                'email_verification' => 'sometimes|boolean',
                'session_timeout' => 'sometimes|integer|min:15|max:480',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            return response()->json([
                'success' => true,
                'message' => 'Settings updated successfully',
                'data' => $request->all()
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to update settings: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update settings: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get public settings.
     * GET /api/v1/auth/settings/public
     */
    public function public()
    {
        try {
            return response()->json([
                'success' => true,
                'message' => 'Public settings fetched successfully',
                'data' => [
                    'app_name' => config('app.name'),
                    'contact_email' => 'info@library.com',
                    'contact_phone' => '021-1234567',
                    'address' => 'Jl. Perpustakaan No. 123, Jakarta',
                    'operational_hours' => [
                        'monday_friday' => '08:00 - 17:00',
                        'saturday' => '08:00 - 13:00',
                        'sunday' => 'Closed'
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to get public settings: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to get public settings: ' . $e->getMessage()
            ], 500);
        }
    }
}