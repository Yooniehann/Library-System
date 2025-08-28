@extends('dashboard.admin.index')

@section('title', 'Process Fine Payment')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-white">Process Fine Payment</h1>
        <a href="{{ route('admin.fines.index') }}"
           class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg">
            <i class="fas fa-arrow-left mr-2"></i> Back to Fines
        </a>
    </div>

    <div class="bg-slate-800 rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold text-white mb-4">Fine Details</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="text-gray-400 text-sm">Fine ID</label>
                <p class="text-white font-mono">#{{ $fine->fine_id }}</p>
            </div>
            <div>
                <label class="text-gray-400 text-sm">User</label>
                <p class="text-white">{{ $fine->borrow->user->fullname }}</p>
            </div>
            <div>
                <label class="text-gray-400 text-sm">Book</label>
                <p class="text-white">{{ $fine->borrow->inventory->book->title }}</p>
            </div>
            <div>
                <label class="text-gray-400 text-sm">Type</label>
                <p class="text-white capitalize">{{ $fine->fine_type }}</p>
            </div>
            <div>
                <label class="text-gray-400 text-sm">Amount to Pay</label>
                <p class="text-white font-medium text-xl">${{ number_format($totalAmount, 2) }}</p>
            </div>
        </div>

        <form action="{{ route('admin.payments.process-fine', $fine->fine_id) }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-400 text-sm mb-2">Payment Method *</label>
                    <select name="payment_method" required
                        class="w-full bg-slate-700 border border-gray-600 text-white rounded-lg py-2 px-4">
                        <option value="cash">Cash</option>
                        <option value="card">Card</option>
                        <option value="online">Online</option>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-400 text-sm mb-2">Transaction ID (Optional)</label>
                    <input type="text" name="transaction_id"
                        class="w-full bg-slate-700 border border-gray-600 text-white rounded-lg py-2 px-4">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-gray-400 text-sm mb-2">Notes (Optional)</label>
                    <textarea name="notes" rows="3"
                        class="w-full bg-slate-700 border border-gray-600 text-white rounded-lg py-2 px-4"></textarea>
                </div>
            </div>

            <div class="mt-6">
                <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg">
                    <i class="fas fa-check mr-2"></i> Confirm Payment
                </button>
            </div>
        </form>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endsection
