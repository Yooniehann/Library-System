@extends('dashboard.admin.index')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold text-white mb-6">Add New User</h1>

        <div class="bg-slate-800 rounded-lg shadow p-6">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Personal Information -->
                    <div class="md:col-span-2">
                        <h2 class="text-xl font-semibold text-yellow-400 mb-4 border-b border-gray-700 pb-2">Personal
                            Information</h2>
                    </div>

                    <div class="mb-4">
                        <label for="fullname" class="block text-gray-300 text-sm font-bold mb-2">Full Name *</label>
                        <input type="text" name="fullname" id="fullname"
                            class="bg-slate-700 text-white border border-gray-600 rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                            required value="{{ old('fullname') }}">
                        @error('fullname')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-gray-300 text-sm font-bold mb-2">Email *</label>
                        <input type="email" name="email" id="email"
                            class="bg-slate-700 text-white border border-gray-600 rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                            required value="{{ old('email') }}">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="block text-gray-300 text-sm font-bold mb-2">Password *</label>
                        <input type="password" name="password" id="password"
                            class="bg-slate-700 text-white border border-gray-600 rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                            required>
                        <p class="text-xs text-gray-400 mt-1">Must contain: 8+ characters, uppercase, lowercase, number</p>
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="block text-gray-300 text-sm font-bold mb-2">Confirm
                            Password *</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="bg-slate-700 text-white border border-gray-600 rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                            required>
                    </div>

                    <div class="mb-4">
                        <label for="phone" class="block text-gray-300 text-sm font-bold mb-2">Phone Number</label>
                        <input type="text" name="phone" id="phone"
                            class="bg-slate-700 text-white border border-gray-600 rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                            value="{{ old('phone') }}">
                        @error('phone')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="date_of_birth" class="block text-gray-300 text-sm font-bold mb-2">Date of Birth
                            *</label>
                        <input type="date" name="date_of_birth" id="date_of_birth"
                            class="bg-slate-700 text-white border border-gray-600 rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                            value="{{ old('date_of_birth') }}" required>
                        @error('date_of_birth')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="gender" class="block text-gray-300 text-sm font-bold mb-2">Gender *</label>
                        <select name="gender" id="gender" required
                            class="bg-slate-700 text-white border border-gray-600 rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                            <option value="">Select Gender</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4 md:col-span-2">
                        <label for="address" class="block text-gray-300 text-sm font-bold mb-2">Address</label>
                        <textarea name="address" id="address" rows="3"
                            class="bg-slate-700 text-white border border-gray-600 rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-yellow-400">{{ old('address') }}</textarea>
                        @error('address')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Account Information -->
                    <div class="md:col-span-2">
                        <h2 class="text-xl font-semibold text-yellow-400 mb-4 border-b border-gray-700 pb-2">Account
                            Information</h2>
                    </div>

                    <div class="mb-4">
                        <label for="role" class="block text-gray-300 text-sm font-bold mb-2">Role *</label>
                        <select name="role" id="role" required
                            class="bg-slate-700 text-white border border-gray-600 rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                            <option value="Guest" {{ old('role') == 'Guest' ? 'selected' : '' }}>Guest</option>
                            <option value="Member" {{ old('role') == 'Member' ? 'selected' : '' }}>Member</option>
                            <option value="Librarian" {{ old('role') == 'Librarian' ? 'selected' : '' }}>Librarian</option>
                        </select>
                        @error('role')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="status" class="block text-gray-300 text-sm font-bold mb-2">Status *</label>
                        <select name="status" id="status" required
                            class="bg-slate-700 text-white border border-gray-600 rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="suspended" {{ old('status') == 'suspended' ? 'selected' : '' }}>Suspended
                            </option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4 flex items-center">
                        <input type="checkbox" name="is_kid" id="is_kid" value="1"
                            {{ old('is_kid') ? 'checked' : '' }}
                            class="rounded bg-slate-700 border-gray-600 text-yellow-400 focus:ring-yellow-400">
                        <label for="is_kid" class="ml-2 block text-sm text-gray-300">Is this a child account?</label>
                        @error('is_kid')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Membership Information -->
                    <div class="md:col-span-2">
                        <h2 class="text-xl font-semibold text-yellow-400 mb-4 border-b border-gray-700 pb-2">Membership
                            Information</h2>
                    </div>

                    <div class="mb-4">
                        <label for="membership_type_id" class="block text-gray-300 text-sm font-bold mb-2">Membership
                            Type</label>
                        <select name="membership_type_id" id="membership_type_id"
                            class="bg-slate-700 text-white border border-gray-600 rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                            <option value="">Select Membership Type</option>
                            @foreach ($membershipTypes as $type)
                                <option value="{{ $type->membership_type_id }}"
                                    {{ old('membership_type_id') == $type->membership_type_id ? 'selected' : '' }}>
                                    {{ $type->type_name }} - ${{ $type->membership_monthly_fee }}/month
                                </option>
                            @endforeach
                        </select>
                        @error('membership_type_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="membership_period" class="block text-gray-300 text-sm font-bold mb-2">Billing
                            Period</label>
                        <select name="membership_period" id="membership_period"
                            class="bg-slate-700 text-white border border-gray-600 rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                            <option value="monthly" {{ old('membership_period') == 'monthly' ? 'selected' : '' }}>Monthly
                            </option>
                            <option value="yearly" {{ old('membership_period') == 'yearly' ? 'selected' : '' }}>Yearly
                            </option>
                        </select>
                        @error('membership_period')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="membership_duration" class="block text-gray-300 text-sm font-bold mb-2">Duration
                            (Months/Years)</label>
                        <input type="number" name="membership_duration" id="membership_duration" min="1"
                            max="60"
                            class="bg-slate-700 text-white border border-gray-600 rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                            value="{{ old('membership_duration', 1) }}">
                        @error('membership_duration')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="membership_start_date" class="block text-gray-300 text-sm font-bold mb-2">Start
                            Date</label>
                        <input type="date" name="membership_start_date" id="membership_start_date"
                            class="bg-slate-700 text-white border border-gray-600 rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                            value="{{ old('membership_start_date', date('Y-m-d')) }}">
                        @error('membership_start_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="membership_end_date" class="block text-gray-300 text-sm font-bold mb-2">End
                            Date</label>
                        <input type="date" name="membership_end_date" id="membership_end_date" readonly
                            class="bg-slate-600 text-gray-400 border border-gray-600 rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                            value="{{ old('membership_end_date') }}">
                        @error('membership_end_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-300 text-sm font-bold mb-2">Membership Cost</label>
                        <div class="bg-slate-700 text-white border border-gray-600 rounded w-full py-2 px-3">
                            <span id="membership_cost_display">$0.00</span>
                            <span id="cost_calculation" class="text-xs text-gray-400 ml-2"></span>
                        </div>
                        <input type="hidden" name="total_cost" id="total_cost" value="0">
                    </div>
                </div>

                <div class="flex items-center justify-end mt-6">
                    <a href="{{ route('admin.users.index') }}"
                        class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                        Cancel
                    </a>
                    <button type="submit"
                        class="bg-yellow-400 hover:bg-yellow-500 text-black font-bold py-2 px-4 rounded">
                        Save User
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        /* Fix dropdown visibility */
        select,
        select option {
            background-color: #1e293b !important;
            color: white !important;
            padding: 0.5rem;
        }

        select:focus,
        select:focus option {
            background-color: #1e293b !important;
            color: white !important;
        }

        /* For Firefox */
        select {
            -moz-appearance: none;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23EEBA30'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 1rem;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const durationInput = document.getElementById('membership_duration');
            const periodSelect = document.getElementById('membership_period');
            const startDateInput = document.getElementById('membership_start_date');
            const endDateInput = document.getElementById('membership_end_date');

            function calculateEndDate() {
                if (startDateInput.value && durationInput.value) {
                    const startDate = new Date(startDateInput.value);
                    const duration = parseInt(durationInput.value);
                    const period = periodSelect.value;

                    const endDate = new Date(startDate);

                    if (period === 'yearly') {
                        endDate.setFullYear(startDate.getFullYear() + duration);
                    } else {
                        endDate.setMonth(startDate.getMonth() + duration);
                    }

                    // Format date as YYYY-MM-DD
                    const formattedDate = endDate.toISOString().split('T')[0];
                    endDateInput.value = formattedDate;
                }
            }

            durationInput.addEventListener('input', calculateEndDate);
            periodSelect.addEventListener('change', calculateEndDate);
            startDateInput.addEventListener('change', calculateEndDate);

            // Calculate initial end date
            calculateEndDate();

            // Calculate membership cost
            function calculateCost() {
                const membershipTypeSelect = document.getElementById('membership_type_id');
                const periodSelect = document.getElementById('membership_period');
                const durationInput = document.getElementById('membership_duration');
                const costDisplay = document.getElementById('membership_cost_display');
                const costCalculation = document.getElementById('cost_calculation');
                const totalCostInput = document.getElementById('total_cost');

                if (membershipTypeSelect.value && durationInput.value) {
                    const selectedOption = membershipTypeSelect.options[membershipTypeSelect.selectedIndex];
                    const typeName = selectedOption.text.split(' - ')[0];
                    const monthlyFee = parseFloat(selectedOption.text.split('$')[1].split('/')[0]);
                    const period = periodSelect.value;
                    const duration = parseInt(durationInput.value);

                    let totalCost = 0;
                    let calculationText = '';

                    if (period === 'yearly') {
                        // For yearly, use annual fee if available, otherwise calculate from monthly
                        const annualFeeText = selectedOption.text.toLowerCase();
                        if (annualFeeText.includes('yearly') || annualFeeText.includes('annual')) {
                            const annualFee = parseFloat(selectedOption.text.split('$')[2] || selectedOption.text
                                .split('$')[1].split('or')[1]);
                            totalCost = annualFee * duration;
                            calculationText = `$${annualFee} yearly × ${duration} year(s)`;
                        } else {
                            totalCost = monthlyFee * 12 * duration;
                            calculationText = `$${monthlyFee} monthly × 12 months × ${duration} year(s)`;
                        }
                    } else {
                        totalCost = monthlyFee * duration;
                        calculationText = `$${monthlyFee} monthly × ${duration} month(s)`;
                    }

                    costDisplay.textContent = `$${totalCost.toFixed(2)}`;
                    costCalculation.textContent = calculationText;
                    totalCostInput.value = totalCost.toFixed(2);
                } else {
                    costDisplay.textContent = '$0.00';
                    costCalculation.textContent = '';
                    totalCostInput.value = '0';
                }
            }

            // Add event listeners for cost calculation
            document.getElementById('membership_type_id').addEventListener('change', function() {
                calculateCost();
                calculateEndDate();
            });

            document.getElementById('membership_period').addEventListener('change', function() {
                calculateCost();
                calculateEndDate();
            });

            document.getElementById('membership_duration').addEventListener('input', function() {
                calculateCost();
                calculateEndDate();
            });

            // Calculate initial cost
            calculateCost();
        });
    </script>
@endsection
