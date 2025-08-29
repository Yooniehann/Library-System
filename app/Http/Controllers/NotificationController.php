<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
            ->orderBy('created_at', 'desc')
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

        Notification::create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'message' => $request->message,
            'notification_type' => $request->notification_type,
            'delivery_method' => $request->delivery_method,
            'status' => 'sent',
            'sent_date' => Carbon::now() // Use Carbon for proper time handling
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
                    ->orWhere('notification_type', 'like', "%{$searchTerm}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        // Add is_new property to each notification
        $notifications->getCollection()->transform(function ($notification) {
            $notification->is_new = is_null($notification->viewed_at);
            return $notification;
        });

        return view('dashboard.member.notifications.index', compact('notifications', 'searchTerm'));
    }

    // Member: View notification details
    public function show($id)
    {
        $notification = Notification::findOrFail($id);
        
        if ($notification->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        // Mark as read by updating viewed_at timestamp
        if (!$notification->viewed_at) {
            $notification->update(['viewed_at' => Carbon::now()]);
        }

        // Add is_new property
        $notification->is_new = false;

        return view('dashboard.member.notifications.show', compact('notification'));
    }

    // Member: Mark notification as read
    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        
        if ($notification->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        // Update viewed_at instead of deleting
        $notification->update(['viewed_at' => Carbon::now()]);

        return redirect()->back()->with('success', 'Notification marked as read');
    }

    // Member: Mark all notifications as read
    public function markAllAsRead()
    {
        Auth::user()->notifications()
            ->whereNull('viewed_at')
            ->update(['viewed_at' => Carbon::now()]);

        return redirect()->back()->with('success', 'All notifications marked as read');
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