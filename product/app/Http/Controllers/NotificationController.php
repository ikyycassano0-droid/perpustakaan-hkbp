<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', user_id())
            ->latest()
            ->get();
            
        $unreadCount = Notification::where('user_id', user_id())
            ->where('is_read', false)
            ->count();

        return view('user.page.inbox', compact('notifications', 'unreadCount'));
    }

    public function markRead($id)
    {
        Notification::where('id', $id)
            ->where('user_id', user_id())
            ->update(['is_read' => true]);
            
        return response()->json(['success' => true]);
    }

    public function markAllRead()
    {
        Notification::where('user_id', user_id())
            ->where('is_read', false)
            ->update(['is_read' => true]);
            
        return response()->json(['success' => true]);
    }
}