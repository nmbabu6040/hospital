<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function recent()
    {
        $admin = auth('admin')->user();

        $notifications = AdminNotification::forAdmin($admin)
            ->latest()
            ->take(10)
            ->get();

        $unreadCount = AdminNotification::forAdmin($admin)->where('is_read', false)->count();

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unreadCount,
        ]);
    }

    public function markAllRead()
    {
        $admin = auth('admin')->user();

        AdminNotification::forAdmin($admin)->where('is_read', false)->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

    public function markRead(AdminNotification $notification)
    {
        $notification->update(['is_read' => true]);

        return redirect($notification->link ?: route('admin.dashboard'));
    }

    public function index()
    {
        $admin = auth('admin')->user();

        $notifications = AdminNotification::forAdmin($admin)->latest()->paginate(30);

        return view('admin.notifications.index', compact('notifications'));
    }
}
