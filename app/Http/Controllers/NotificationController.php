<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use App\Models\SimulationSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // Admin: View all notifications
    public function adminIndex(Request $request)
    {
        $searchTerm = $request->input('search');
        
        $notifications = Notification::with('user')
            ->when($searchTerm, function ($query, $searchTerm) {
                return $query->where('title', 'like', "%{$searchTerm}%")
                    ->orWhere('message', 'like', "%{$searchTerm}%")
                    ->orWhere('notification_type', 'like', "%{$searchTerm}%")
                    ->orWhereHas('user', function ($q) use ($searchTerm) {
                        $q->where('fullname', 'like', "%{$searchTerm}%");
                    });
            })
            ->orderBy('sent_date', 'desc')
            ->paginate(20);

        return view('dashboard.admin.notifications.index', compact('notifications', 'searchTerm'));
    }

    // Admin: Show create form
    public function create()
    {
        $users = User::whereIn('role', ['Member', 'Kid'])->get();
        return view('dashboard.admin.notifications.create', compact('users'));
    }

    // Admin: Store new notification
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'title' => 'required|string|max:100',
            'message' => 'required|string',
            'notification_type' => 'required|in:due_reminder,overdue,fine,reservation_ready,general',
            'delivery_method' => 'required|in:email,sms,system'
        ]);

        // Use simulated time if active, otherwise use current time
        $sentDate = SimulationSetting::getCurrentDate();

        Notification::create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'message' => $request->message,
            'notification_type' => $request->notification_type,
            'delivery_method' => $request->delivery_method,
            'status' => 'sent',
            'sent_date' => $sentDate
        ]);

        return redirect()->route('admin.notifications.index')
            ->with('success', 'Notification sent successfully!');
    }

    // Member: View own notifications
    public function memberIndex(Request $request)
    {
        $searchTerm = $request->input('search');
        
        $notifications = Auth::user()->notifications()
            ->when($searchTerm, function ($query, $searchTerm) {
                return $query->where('title', 'like', "%{$searchTerm}%")
                    // ->orWhere('message', 'like', "%{$searchTerm}%")
                    ->orWhere('notification_type', 'like', "%{$searchTerm}%");
            })
            ->orderBy('sent_date', 'desc')
            ->paginate(15);

        return view('dashboard.member.notifications.index', compact('notifications', 'searchTerm'));
    }

    // Member: Mark notification as read (simple delete)
    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        
        if ($notification->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $notification->delete();

        return redirect()->back()->with('success', 'Notification marked as read');
    }

    // Admin: Delete notification
    public function destroy($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->delete();

        return redirect()->route('admin.notifications.index')
            ->with('success', 'Notification deleted successfully!');
    }
}