<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MembershipType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class UserController extends Controller
{
    // Display all users with search functionality
    public function index()
    {
        $search = request('search');
        
        $users = User::with('membershipType')
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('fullname', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('role', 'like', "%{$search}%")
                    ->orWhereHas('membershipType', function ($q) use ($search) {
                        $q->where('type_name', 'like', "%{$search}%");
                    });
                });
            })
            ->latest()
            ->paginate(10);

        return view('dashboard.admin.users.index', compact('users'));
    }

    // Show create form
    public function create()
    {
        $membershipTypes = MembershipType::all();
        return view('dashboard.admin.users.create', compact('membershipTypes'));
    }

    // Store new user
    public function store(Request $request)
    {
        // Custom validation messages
        $messages = [
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, and one number.',
            'membership_end_date.after' => 'End date must be after the start date.',
        ];

        $validated = $request->validate([
            'membership_type_id' => 'nullable|exists:membership_types,membership_type_id',
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            ],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'date_of_birth' => 'required|date|before:today',
            'gender' => 'required|in:male,female,other',
            'role' => 'required|in:Guest,Member,Librarian',
            'is_kid' => 'boolean',
            'membership_duration' => 'required_if:role,Member|nullable|integer|min:1',
            'membership_period' => 'required_if:role,Member|nullable|in:monthly,yearly',
            'membership_start_date' => 'required_if:role,Member|nullable|date',
            'membership_end_date' => 'nullable|date|after:membership_start_date',
            'status' => 'required|in:active,inactive,suspended',
        ], $messages);

        // Calculate end date if duration and period are provided
        if ($request->filled('membership_start_date') && $request->filled('membership_duration') && $request->filled('membership_period')) {
            $startDate = Carbon::parse($request->membership_start_date);
            
            $duration = (int) $request->membership_duration;

            if ($request->membership_period === 'yearly') {
                $endDate = $startDate->copy()->addYears($duration);
            } else {
                $endDate = $startDate->copy()->addMonths($duration);
            }
            
            $validated['membership_end_date'] = $endDate->format('Y-m-d');
        }

        // Hash the password
        $validated['password'] = Hash::make($validated['password']);

        // Set default role if not provided
        if (!isset($validated['role'])) {
            $validated['role'] = 'Guest';
        }

        User::create($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully!');
    }

    // Show edit form
    public function edit(User $user)
    {
        $membershipTypes = MembershipType::all();
        return view('dashboard.admin.users.edit', compact('user', 'membershipTypes'));
    }

    // Update user
    public function update(Request $request, User $user)
    {
        // Custom validation messages
        $messages = [
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, and one number.',
            'membership_end_date.after' => 'End date must be after the start date.',
        ];

        $validated = $request->validate([
            'membership_type_id' => 'nullable|exists:membership_types,membership_type_id',
            'fullname' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->user_id, 'user_id')
            ],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'date_of_birth' => 'required|date|before:today',
            'gender' => 'required|in:male,female,other',
            'role' => 'required|in:Guest,Member,Librarian',
            'is_kid' => 'boolean',
            'membership_duration' => 'required_if:role,Member|nullable|integer|min:1',
            'membership_period' => 'required_if:role,Member|nullable|in:monthly,yearly',
            'membership_start_date' => 'required_if:role,Member|nullable|date',
            'membership_end_date' => 'nullable|date|after:membership_start_date',
            'status' => 'required|in:active,inactive,suspended',
        ], $messages);

        // Calculate end date if duration and period are provided
        if ($request->filled('membership_start_date') && $request->filled('membership_duration') && $request->filled('membership_period')) {
            $startDate = Carbon::parse($request->membership_start_date);
            
            $duration = (int) $request->membership_duration;
            if ($request->membership_period === 'yearly') {
                $endDate = $startDate->copy()->addYears($duration);
            } else {
                $endDate = $startDate->copy()->addMonths($duration);
            }
            
            $validated['membership_end_date'] = $endDate->format('Y-m-d');
        }

        // Handle password update if provided
        if ($request->filled('password')) {
            $request->validate([
                'password' => [
                    'min:8',
                    'confirmed',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
                ],
            ], $messages);
            $validated['password'] = Hash::make($request->password);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully!');
    }

    // Delete user
    public function destroy(User $user)
    {
        // Prevent deleting yourself or other librarians
        if ($user->role === 'Librarian') {
            return redirect()->route('admin.users.index')
                ->with('error', 'Cannot delete librarian accounts.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully!');
    }
}