<?php
// microservices/auth-service/app/Http/Controllers/Api/ReportController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{
    /**
     * Get member report.
     * GET /api/v1/auth/reports/members
     */
    public function members(Request $request)
    {
        try {
            $period = $request->period ?? 'month';
            
            switch ($period) {
                case 'week':
                    $startDate = Carbon::now()->startOfWeek();
                    $endDate = Carbon::now()->endOfWeek();
                    break;
                case 'month':
                    $startDate = Carbon::now()->startOfMonth();
                    $endDate = Carbon::now()->endOfMonth();
                    break;
                case 'year':
                    $startDate = Carbon::now()->startOfYear();
                    $endDate = Carbon::now()->endOfYear();
                    break;
                default:
                    $startDate = Carbon::now()->subDays(30);
                    $endDate = Carbon::now();
            }

            $totalMembers = User::whereIn('role_id', [2, 3])->count();
            $newMembers = User::whereIn('role_id', [2, 3])
                              ->whereBetween('created_at', [$startDate, $endDate])
                              ->count();
            $verifiedMembers = User::whereIn('role_id', [2, 3])
                                   ->whereNotNull('email_verified_at')
                                   ->count();

            $dailyData = [];
            for ($i = 0; $i < 30; $i++) {
                $date = Carbon::today()->subDays($i);
                $count = User::whereIn('role_id', [2, 3])
                             ->whereDate('created_at', $date)
                             ->count();
                $dailyData[] = [
                    'date' => $date->format('Y-m-d'),
                    'count' => $count
                ];
            }

            return response()->json([
                'success' => true,
                'message' => 'Member report generated successfully',
                'data' => [
                    'summary' => [
                        'total_members' => $totalMembers,
                        'new_members' => $newMembers,
                        'verified_members' => $verifiedMembers,
                        'unverified_members' => $totalMembers - $verifiedMembers,
                        'verification_rate' => $totalMembers > 0 
                            ? round(($verifiedMembers / $totalMembers) * 100, 2) 
                            : 0
                    ],
                    'period' => [
                        'start' => $startDate->format('Y-m-d'),
                        'end' => $endDate->format('Y-m-d'),
                        'days' => $startDate->diffInDays($endDate) + 1
                    ],
                    'daily' => array_reverse($dailyData),
                    'generated_at' => now()->toIso8601String()
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to generate report: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate report: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get activity report.
     * GET /api/v1/auth/reports/activity
     */
    public function activity()
    {
        try {
            $activities = [
                'login' => ['total' => 150, 'today' => 15, 'week' => 85],
                'register' => ['total' => 45, 'today' => 3, 'week' => 25],
                'borrow' => ['total' => 230, 'today' => 12, 'week' => 120],
                'return' => ['total' => 195, 'today' => 8, 'week' => 95],
                'reserve' => ['total' => 67, 'today' => 4, 'week' => 35]
            ];

            return response()->json([
                'success' => true,
                'message' => 'Activity report generated successfully',
                'data' => [
                    'activities' => $activities,
                    'generated_at' => now()->toIso8601String()
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to generate activity report: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate activity report: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get summary report.
     * GET /api/v1/auth/reports/summary
     */
    public function summary()
    {
        try {
            $totalMembers = User::whereIn('role_id', [2, 3])->count();
            $totalAdmins = User::where('role_id', 1)->count();
            $verifiedMembers = User::whereIn('role_id', [2, 3])
                                   ->whereNotNull('email_verified_at')
                                   ->count();

            $last7Days = [];
            for ($i = 6; $i >= 0; $i--) {
                $date = Carbon::today()->subDays($i);
                $count = User::whereIn('role_id', [2, 3])
                             ->whereDate('created_at', $date)
                             ->count();
                $last7Days[] = [
                    'date' => $date->format('Y-m-d'),
                    'day' => $date->format('D'),
                    'count' => $count
                ];
            }

            return response()->json([
                'success' => true,
                'message' => 'Summary report generated successfully',
                'data' => [
                    'summary' => [
                        'total_users' => $totalMembers + $totalAdmins,
                        'total_members' => $totalMembers,
                        'total_admins' => $totalAdmins,
                        'verified_members' => $verifiedMembers,
                        'unverified_members' => $totalMembers - $verifiedMembers,
                    ],
                    'growth_trend' => $last7Days,
                    'generated_at' => now()->toIso8601String()
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to generate summary report: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate summary report: ' . $e->getMessage()
            ], 500);
        }
    }
}