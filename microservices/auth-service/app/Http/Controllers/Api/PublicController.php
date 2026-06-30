<?php
// microservices/auth-service/app/Http/Controllers/Api/PublicController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PublicController extends Controller
{
    /**
     * Get public configuration.
     * GET /api/v1/public/config
     */
    public function config()
    {
        try {
            return response()->json([
                'success' => true,
                'message' => 'Public configuration fetched successfully',
                'data' => [
                    'app_name' => config('app.name'),
                    'api_version' => 'v1',
                    'api_prefix' => '/api/v1',
                    'support_email' => 'support@library.com',
                    'max_upload_size' => '5MB',
                    'allowed_file_types' => ['jpg', 'png', 'pdf', 'docx', 'xlsx'],
                    'timezone' => config('app.timezone'),
                    'locale' => 'id',
                    'features' => [
                        'registration' => true,
                        'email_verification' => true,
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to get public config: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to get public config: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get application information.
     * GET /api/v1/public/app-info
     */
    public function appInfo()
    {
        try {
            return response()->json([
                'success' => true,
                'message' => 'Application info fetched successfully',
                'data' => [
                    'name' => 'Library Management System',
                    'version' => '2.0.0',
                    'environment' => app()->environment(),
                    'php_version' => phpversion(),
                    'laravel_version' => app()->version(),
                    'timestamp' => now()->toIso8601String(),
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to get app info: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to get app info: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Health check endpoint.
     * GET /api/v1/public/health-check
     */
    public function healthCheck()
    {
        try {
            return response()->json([
                'success' => true,
                'status' => 'healthy',
                'service' => 'auth-service',
                'version' => '2.0.0',
                'timestamp' => now()->toIso8601String(),
                'checks' => [
                    'database' => $this->checkDatabase(),
                    'cache' => $this->checkCache(),
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status' => 'unhealthy',
                'message' => 'Health check failed: ' . $e->getMessage()
            ], 500);
        }
    }

    private function checkDatabase()
    {
        try {
            \DB::connection()->getPdo();
            return ['status' => 'connected', 'database' => \DB::connection()->getDatabaseName()];
        } catch (\Exception $e) {
            return ['status' => 'disconnected', 'error' => $e->getMessage()];
        }
    }

    private function checkCache()
    {
        try {
            cache()->put('health_check', 'ok', 60);
            $value = cache()->get('health_check');
            return ['status' => 'working', 'value' => $value];
        } catch (\Exception $e) {
            return ['status' => 'failed', 'error' => $e->getMessage()];
        }
    }
}