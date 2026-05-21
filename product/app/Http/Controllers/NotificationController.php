<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Carbon\Carbon;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', user_id())
            ->latest()
            ->get();

        
        Notification::where('user_id',user_id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('user.page.inbox', compact('notifications'));
    }
}