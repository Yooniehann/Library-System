@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <!-- Glass effect container -->
        <div class="backdrop-blur-sm bg-white/10 rounded-xl shadow-lg p-8 text-white">
            <div class="text-center mb-8">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <h1 class="text-3xl font-bold mt-4">Payment Successful!</h1>
                <p class="text-lg mt-2">Your membership is now active.</p>
            </div>

            <div class="bg-white/20 rounded-lg p-6 mb-8 backdrop-blur-sm">
                <h2 class="text-xl font-bold mb-4">Membership Details</h2>

                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <p class="font-semibold">Plan:</p>
                        <p>{{ $membershipType->type_name }}</p>
                    </div>
                    <div>
                        <p class="font-semibold">Payment Method:</p>
                        <p class="capitalize">{{ str_replace('_', ' ', $paymentMethod) }}</p>
                    </div>
                    <div>
                        <p class="font-semibold">Start Date:</p>
                        <p>{{ date('M d, Y', strtotime($selection['start_date'])) }}</p>
                    </div>
                    <div>
                        <p class="font-semibold">End Date:</p>
                        <p>{{ date('M d, Y', strtotime($selection['end_date'])) }}</p>
                    </div>
                    <div>
                        <p class="font-semibold">Maximum Books:</p>
                        <p>{{ $selection['max_books_allowed'] }}</p>
                    </div>
                    <div>
                        <p class="font-semibold">Amount Paid:</p>
                        <p class="text-xl font-bold">${{ number_format($selection['amount'], 2) }}</p>
                    </div>
                </div>
            </div>

            <div class="text-center">
                @php
                    $dashboardRoute = match(auth()->user()->role) {
                        'Admin' => 'admin.dashboard',
                        'Kid' => 'kid.dashboard',
                        default => 'member.dashboard',
                    };
                @endphp

                <a href="{{ route($dashboardRoute) }}" class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-6 rounded-lg transition duration-200">
                    Go to {{ auth()->user()->role }} Dashboard
                </a>
                <p class="mt-4 text-sm text-white/80">
                    You can now access all {{ auth()->user()->role }} features.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
