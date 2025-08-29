<?php

namespace App\Http\Controllers\Kid;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class KidNotificationController extends Controller
{
    // Display all notifications for the logged-in kid
    public function index()
    {
        $userId = Auth::id();

        // Get notifications for the logged-in user, latest first, paginated
        $notifications = Notification::where('user_id', $userId)
            ->orderBy('sent_date', 'desc')
            ->paginate(10);

        return view('dashboard.kid.kidnoti', compact('notifications'));
    }

    // Mark a notification as read
    public function markAsRead($id)
    {
        $userId = Auth::id();

        $notification = Notification::where('user_id', $userId)
            ->findOrFail($id);

        if ($notification->status !== 'read') {
            $notification->status = 'read';
            $notification->save();
        }

        return redirect()->back()->with('success', 'Notification marked as read.');
    }
}
