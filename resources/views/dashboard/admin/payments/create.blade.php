@extends('dashboard.admin.index')

@section('title', 'Create Payment')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-white">Create New Payment</h1>
        <a href="{{ route('admin.payments.index') }}"
           class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg">
            <i class="fas fa-arrow-left mr-2"></i> Back to Payments
        </a>
    </div>

    <div class="bg-slate-800 rounded-lg shadow p-6">
        <form action="{{ route('admin.payments.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- User Selection -->
                <div class="md:col-span-2">
                    <label class="block text-gray-400 text-sm mb-2">User *</label>
                    <select name="user_id" id="user_id" required
                        class="w-full bg-slate-700 border border-gray-600 text-white rounded-lg py-2 px-4">
                        <option value="">Select User</option>
                        @foreach($users as $user)
                            <option value="{{ $user->user_id }}" {{ old('user_id') == $user->user_id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Payment Type -->
                <div>
                    <label class="block text-gray-400 text-sm mb-2">Payment Type *</label>
                    <select name="payment_type" id="payment_type" required
                        class="w-full bg-slate-700 border border-gray-600 text-white rounded-lg py-2 px-4">
                        <option value="">Select Type</option>
                        <option value="fine" {{ old('payment_type') == 'fine' ? 'selected' : '' }}>Fine Payment</option>
                        <option value="membership_fee" {{ old('payment_type') == 'membership_fee' ? 'selected' : '' }}>Membership Fee</option>
                    </select>
                    @error('payment_type')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Fine Selection (only for fine payments) -->
                <div id="fine_selection" style="display: none;">
                    <label class="block text-gray-400 text-sm mb-2">Select Fine</label>
                    <select name="fine_id" id="fine_id"
                        class="w-full bg-slate-700 border border-gray-600 text-white rounded-lg py-2 px-4">
                        <option value="">Select Fine</option>
                        <!-- Fines will be loaded via AJAX -->
                    </select>
                    @error('fine_id')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Membership Type Selection (only for membership payments) -->
                <div id="membership_selection" style="display: none;">
                    <label class="block text-gray-400 text-sm mb-2">Membership Type</label>
                    <select name="membership_type_id" id="membership_type_id"
                        class="w-full bg-slate-700 border border-gray-600 text-white rounded-lg py-2 px-4">
                        <option value="">Select Membership Type</option>
                        @foreach($membershipTypes as $type)
                            <option value="{{ $type->membership_type_id }}" {{ old('membership_type_id') == $type->membership_type_id ? 'selected' : '' }}>
                                {{ $type->name }} (${{ number_format($type->fee, 2) }})
                            </option>
                        @endforeach
                    </select>
                    @error('membership_type_id')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Amount -->
                <div>
                    <label class="block text-gray-400 text-sm mb-2">Amount *</label>
                    <input type="number" name="amount" id="amount" step="0.01" min="0" required
                        value="{{ old('amount') }}"
                        class="w-full bg-slate-700 border border-gray-600 text-white rounded-lg py-2 px-4">
                    @error('amount')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Payment Method -->
                <div>
                    <label class="block text-gray-400 text-sm mb-2">Payment Method *</label>
                    <select name="payment_method" required
                        class="w-full bg-slate-700 border border-gray-600 text-white rounded-lg py-2 px-4">
                        <option value="">Select Method</option>
                        <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                        <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>Card</option>
                        <option value="online" {{ old('payment_method') == 'online' ? 'selected' : '' }}>Online</option>
                    </select>
                    @error('payment_method')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Transaction ID -->
                <div>
                    <label class="block text-gray-400 text-sm mb-2">Transaction ID</label>
                    <input type="text" name="transaction_id"
                        value="{{ old('transaction_id') }}"
                        class="w-full bg-slate-700 border border-gray-600 text-white rounded-lg py-2 px-4">
                    @error('transaction_id')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Notes -->
                <div class="md:col-span-2">
                    <label class="block text-gray-400 text-sm mb-2">Notes</label>
                    <textarea name="notes" rows="3"
                        class="w-full bg-slate-700 border border-gray-600 text-white rounded-lg py-2 px-4">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
                    <i class="fas fa-save mr-2"></i> Create Payment
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const paymentType = document.getElementById('payment_type');
        const fineSelection = document.getElementById('fine_selection');
        const membershipSelection = document.getElementById('membership_selection');
        const userId = document.getElementById('user_id');
        const fineId = document.getElementById('fine_id');
        const amount = document.getElementById('amount');

        // Show/hide fine or membership selection based on payment type
        paymentType.addEventListener('change', function() {
            if (this.value === 'fine') {
                fineSelection.style.display = 'block';
                membershipSelection.style.display = 'none';
                document.querySelector('[name="membership_type_id"]').required = false;
                document.querySelector('[name="fine_id"]').required = true;
            } else if (this.value === 'membership_fee') {
                fineSelection.style.display = 'none';
                membershipSelection.style.display = 'block';
                document.querySelector('[name="fine_id"]').required = false;
                document.querySelector('[name="membership_type_id"]').required = true;
            } else {
                fineSelection.style.display = 'none';
                membershipSelection.style.display = 'none';
                document.querySelector('[name="fine_id"]').required = false;
                document.querySelector('[name="membership_type_id"]').required = false;
            }
        });

        // Load user's unpaid fines when user is selected
        userId.addEventListener('change', function() {
            if (this.value && paymentType.value === 'fine') {
                fetch(`/admin/payments/user-fines/${this.value}`)
                    .then(response => response.json())
                    .then(data => {
                        fineId.innerHTML = '<option value="">Select Fine</option>';
                        data.forEach(fine => {
                            const option = document.createElement('option');
                            option.value = fine.fine_id;
                            option.textContent = `Fine #${fine.fine_id} - ${fine.borrow.inventory.book.title} - $${fine.amount_per_day}`;
                            option.dataset.amount = fine.amount_per_day;
                            fineId.appendChild(option);
                        });
                    });
            }
        });

        // Auto-fill amount when fine is selected
        fineId.addEventListener('change', function() {
            if (this.value) {
                const selectedOption = this.options[this.selectedIndex];
                amount.value = selectedOption.dataset.amount;
            }
        });

        // Trigger change event on page load if values are pre-filled
        if (paymentType.value) {
            paymentType.dispatchEvent(new Event('change'));
        }

        // Pre-select fine if coming from fines page
        @if(request('fine_id'))
            document.addEventListener('DOMContentLoaded', function() {
                paymentType.value = 'fine';
                paymentType.dispatchEvent(new Event('change'));

                // Set a timeout to allow the AJAX call to complete
                setTimeout(function() {
                    fineId.value = '{{ request('fine_id') }}';
                    fineId.dispatchEvent(new Event('change'));
                }, 500);
            });
        @endif
    });
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endsection
