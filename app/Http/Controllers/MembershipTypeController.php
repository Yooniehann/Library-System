<?php

namespace App\Http\Controllers;

use App\Models\MembershipType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class MembershipTypeController extends Controller
{
    public function select($type)
    {
        $user = Auth::user();

        if ($user->role !== 'Guest') {
            return redirect()->route('home')->with(
                'info',
                '🎉 You are already an active member! No need to purchase another membership plan.'
            );
        }


        $membershipType = MembershipType::findOrFail($type);
        return view('membership.select', ['membershipType' => $membershipType]);
    }

    public function choose(Request $request)
    {
        $user = Auth::user();

        if ($user->role !== 'Guest') {
            return redirect()->route('home')->with('info', 'You already have an active membership');
        }

        $validated = $request->validate([
            'membership_type_id' => 'required|exists:membership_types,membership_type_id',
            'duration' => 'required|in:monthly,yearly',
            'months' => 'required_if:duration,monthly|integer|min:1|max:12',
            'start_date' => 'required|date|after_or_equal:today',
            'calculated_end_date' => 'required|date|after:start_date'
        ]);

        $membershipType = MembershipType::findOrFail($validated['membership_type_id']);

        $selection = [
            'membership_type_id' => $membershipType->membership_type_id,
            'type_name' => $membershipType->type_name,
            'description' => $membershipType->description,
            'duration' => $validated['duration'],
            'months' => $validated['duration'] === 'monthly' ? $validated['months'] : 12,
            'amount' => $validated['duration'] === 'yearly'
                ? $membershipType->membership_annual_fee
                : $membershipType->membership_monthly_fee * $validated['months'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['calculated_end_date'],
            'max_books_allowed' => $membershipType->max_books_allowed
        ];

        session(['membership_selection' => $selection]);
        return redirect()->route('membership.payment');
    }

    public function payment()
    {
        if (!session()->has('membership_selection')) {
            return redirect()->route('membership.select', MembershipType::first()->membership_type_id)
                ->with('error', 'Please select a membership plan first');
        }

        $selection = session('membership_selection');
        $membershipType = MembershipType::find($selection['membership_type_id']);

        if (!$membershipType) {
            return redirect()->route('membership.select', MembershipType::first()->membership_type_id)
                ->with('error', 'Invalid membership plan selected');
        }

        return view('membership.payment', [
            'membershipType' => $membershipType,
            'selection' => $selection
        ]);
    }

    public function processPayment(Request $request)
    {
        if (!session()->has('membership_selection')) {
            return redirect()->route('membership.select')
                ->with('error', 'Your session expired. Please select a membership plan again.');
        }

        $request->validate([
            'payment_method' => 'required|in:credit_card,paypal,bank_transfer'
        ]);

        $selection = session('membership_selection');
        $user = Auth::user();

        try {
            $role = $user->is_kid ? 'Kid' : 'Member';

            // Update user with new membership details
            $user->update([
                'membership_type_id' => $selection['membership_type_id'],
                'role' => $role,
                'membership_start_date' => $selection['start_date'],
                'membership_end_date' => $selection['end_date'],
                'status' => 'active',
                'max_books_allowed' => $selection['max_books_allowed']
            ]);

            // Force refresh auth user and session
            Auth::logout();
            Auth::login($user->fresh());
            Session::regenerate();

            // Store payment method for success page
            session(['payment_method' => $request->payment_method]);
            session(['membership_upgraded' => true]); // Flag for middleware

            return redirect()->route('membership.success');
        } catch (\Exception $e) {
            Log::error('Payment processing failed: ' . $e->getMessage());
            return back()->with('error', 'Payment failed. Please try again.')->withInput();
        }
    }

    public function success()
    {
        $user = Auth::user();

        if (!$user->hasActiveMembership()) {
            return redirect()->route('home');
        }

        $selection = session('membership_selection', []);
        $paymentMethod = session('payment_method', 'credit_card');

        // Clear session data except the upgrade flag
        session()->forget(['membership_selection', 'payment_method']);

        return view('membership.success', [
            'membershipType' => MembershipType::find($user->membership_type_id),
            'paymentMethod' => $paymentMethod,
            'selection' => $selection
        ]);
    }
}
