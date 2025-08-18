@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Back to Home Link -->
    <div class="mb-6">
        <a href="{{ route('home') }}" class="flex items-center text-yellow-400 hover:text-yellow-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Back to Home
        </a>
    </div>

    <h1 class="text-3xl font-bold mb-8 text-white text-center">Choose Your Membership Plan</h1>

    <div class="max-w-lg mx-auto">
        <div class="border rounded-lg p-6 shadow-md hover:shadow-lg transition-shadow bg-gray-800">
            <div class="text-center mb-6">
                <h2 class="text-xl font-bold text-white">{{ $membershipType->type_name }}</h2>
                <p class="text-gray-300">{{ $membershipType->description }}</p>
            </div>

            <div class="text-center mb-6 text-white">
                <span class="text-3xl font-bold">${{ $membershipType->membership_monthly_fee }}</span>
                <span class="text-gray-300">/month</span>
                <p class="text-gray-300 mt-2">or ${{ $membershipType->membership_annual_fee }} annually</p>
            </div>

            <ul class="space-y-2 mb-6 text-white">
                <li class="flex items-start">
                    <span class="text-green-500 mr-2">✓</span>
                    <span>Maximum Books Allowed: {{ $membershipType->max_books_allowed }}</span>
                </li>
            </ul>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('membership.choose') }}" id="membership-form">
                @csrf
                <input type="hidden" name="membership_type_id" value="{{ $membershipType->membership_type_id }}">

                <div class="mb-4 text-white">
                    <label class="block mb-2">Duration</label>
                    <div class="flex space-x-4">
                        <label class="inline-flex items-center">
                            <input type="radio" name="duration" value="monthly" checked class="form-radio duration-radio">
                            <span class="ml-2">Monthly</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="duration" value="yearly" class="form-radio duration-radio">
                            <span class="ml-2">Yearly</span>
                        </label>
                    </div>
                </div>

                <div class="mb-4" id="months-selection">
                    <label class="block mb-2 text-white">Number of Months</label>
                    <select name="months" class="form-select block w-full">
                        @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}">{{ $i }} month{{ $i > 1 ? 's' : '' }}</option>
                        @endfor
                    </select>
                </div>

                <div class="mb-4 text-black">
                    <label class="block mb-2 text-white">Start Date</label>
                    <input type="date" name="start_date" class="form-input w-full start-date" min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}">
                </div>

                <div class="mb-4 text-black">
                    <label class="block mb-2 text-white">End Date</label>
                    <input type="date" name="end_date" class="form-input w-full end-date" readonly>
                </div>

                <input type="hidden" name="calculated_end_date" id="calculated-end-date">

                <button type="submit" class="w-full bg-yellow-400 text-black py-2 px-4 rounded hover:bg-yellow-500">
                    Select Plan
                </button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const durationRadios = document.querySelectorAll('.duration-radio');
    const monthsSelection = document.getElementById('months-selection');
    const startDateInput = document.querySelector('.start-date');
    const endDateInput = document.querySelector('.end-date');
    const monthsSelect = document.querySelector('select[name="months"]');
    const calculatedEndDate = document.getElementById('calculated-end-date');

    // Initialize
    updateEndDate();

    // Event listeners
    durationRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            monthsSelection.style.display = this.value === 'monthly' ? 'block' : 'none';
            updateEndDate();
        });
    });

    startDateInput.addEventListener('change', updateEndDate);
    monthsSelect.addEventListener('change', updateEndDate);

    function updateEndDate() {
        const startDate = new Date(startDateInput.value);
        const duration = document.querySelector('input[name="duration"]:checked').value;
        const months = parseInt(monthsSelect.value);

        const endDate = new Date(startDate);

        if (duration === 'yearly') {
            endDate.setFullYear(endDate.getFullYear() + 1);
        } else {
            endDate.setMonth(endDate.getMonth() + months);
        }

        const formattedDate = endDate.toISOString().split('T')[0];
        endDateInput.value = formattedDate;
        calculatedEndDate.value = formattedDate;
    }
});
</script>
@endsection
