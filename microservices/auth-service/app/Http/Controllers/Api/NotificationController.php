<?php
// microservices/auth-service/app/Http/Controllers/Api/NotificationController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    /**
     * Get user notifications.
     * GET /api/v1/auth/notifications
     */
    public function index(Request $request)
    {
        try {
            $notifications = [
                [
                    'id' => 1,
                    'type' => 'book_due',
                    'title' => 'Book Due Tomorrow',
                    'message' => 'Your book is due tomorrow. Please return it to avoid fines.',
                    'is_read' => false,
                    'created_at' => now()->subHours(2)
                ],
                [
                    'id' => 2,
                    'type' => 'new_book',
                    'title' => 'New Book Available',
                    'message' => 'We have added 5 new books to our collection.',
                    'is_read' => false,
                    'created_at' => now()->subHours(5)
                ],
                [
                    'id' => 3,
                    'type' => 'membership',
                    'title' => 'Membership Expiring Soon',
                    'message' => 'Your membership will expire in 7 days.',
                    'is_read' => true,
                    'created_at' => now()->subDays(3)
                ],
            ];

            if ($request->has('filter')) {
                if ($request->filter === 'unread') {
                    $notifications = array_filter($notifications, function ($n) {
                        return !$n['is_read'];
                    });
                } elseif ($request->filter === 'read') {
                    $notifications = array_filter($notifications, function ($n) {
                        return $n['is_read'];
                    });
                }
            }

            $unreadCount = count(array_filter($notifications, function ($n) {
                return !$n['is_read'];
            }));

            return response()->json([
                'success' => true,
                'message' => 'Notifications fetched successfully',
                'data' => array_values($notifications),
                'meta' => [
                    'total' => count($notifications),
                    'unread_count' => $unreadCount
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to get notifications: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to get notifications: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mark a notification as read.
     * POST /api/v1/auth/notifications/{id}/read
     */
    public function markRead($id)
    {
        try {
            return response()->json([
                'success' => true,
                'message' => 'Notification marked as read successfully',
                'data' => ['notification_id' => $id]
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to mark notification as read: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to mark notification as read: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mark all notifications as read.
     * POST /api/v1/auth/notifications/read-all
     */
    public function markAllRead()
    {
        try {
            return response()->json([
                'success' => true,
                'message' => 'All notifications marked as read successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to mark all notifications: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to mark all notifications: ' . $e->getMessage()
            ], 500);
        }
    }
}