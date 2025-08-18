@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <!-- Glass effect header -->
        <div class="backdrop-blur-sm bg-white/10 rounded-xl p-6 mb-8 shadow-lg">
            <h1 class="text-3xl font-bold text-white text-center">Complete Your Membership</h1>
            <p class="text-white/80 text-center mt-2">Final step to access our library resources</p>
        </div>

        <!-- Glass effect membership summary -->
        <div class="backdrop-blur-sm bg-white/10 rounded-xl shadow-lg p-6 mb-8">
            <h2 class="text-xl font-bold mb-4 text-white">Membership Summary</h2>

            <div class="grid md:grid-cols-2 gap-4 mb-6 text-white">
                <div class="bg-white/5 p-4 rounded-lg">
                    <p class="font-semibold text-white/80">Plan:</p>
                    <p class="text-lg">{{ $membershipType->type_name }}</p>
                </div>
                <div class="bg-white/5 p-4 rounded-lg">
                    <p class="font-semibold text-white/80">Duration:</p>
                    <p class="text-lg">{{ $selection['duration'] === 'yearly' ? '1 Year' : $selection['months'] . ' Month(s)' }}</p>
                </div>
                <div class="bg-white/5 p-4 rounded-lg">
                    <p class="font-semibold text-white/80">Total:</p>
                    <p class="text-xl font-bold text-blue-300">${{ number_format($selection['amount'], 2) }}</p>
                </div>
                <div class="bg-white/5 p-4 rounded-lg">
                    <p class="font-semibold text-white/80">Maximum Books:</p>
                    <p class="text-lg">{{ $selection['max_books_allowed'] }}</p>
                </div>
                <div class="bg-white/5 p-4 rounded-lg">
                    <p class="font-semibold text-white/80">Start Date:</p>
                    <p class="text-lg">{{ date('M d, Y', strtotime($selection['start_date'])) }}</p>
                </div>
                <div class="bg-white/5 p-4 rounded-lg">
                    <p class="font-semibold text-white/80">End Date:</p>
                    <p class="text-lg">{{ date('M d, Y', strtotime($selection['end_date'])) }}</p>
                </div>
            </div>
        </div>

        <!-- Glass effect payment form -->
        <div class="backdrop-blur-sm bg-white/10 rounded-xl shadow-lg p-6">
            <h2 class="text-xl font-bold mb-4 text-white">Payment Information</h2>

            <form method="POST" action="{{ route('membership.process-payment') }}">
                @csrf

                <div class="mb-6">
                    <label class="block font-medium mb-2 text-white">Payment Method</label>
                    <div class="space-y-3">
                        <label class="flex items-center p-4 border border-white/20 rounded-lg cursor-pointer hover:bg-white/10 transition">
                            <input type="radio" name="payment_method" value="credit_card" checked
                                   class="form-radio h-5 w-5 text-blue-400 border-white/50">
                            <span class="ml-3">
                                <span class="block font-medium text-white">Credit/Debit Card</span>
                                <span class="block text-sm text-white/60">Visa, Mastercard, American Express</span>
                            </span>
                        </label>

                        <label class="flex items-center p-4 border border-white/20 rounded-lg cursor-pointer hover:bg-white/10 transition">
                            <input type="radio" name="payment_method" value="paypal"
                                   class="form-radio h-5 w-5 text-blue-400 border-white/50">
                            <span class="ml-3">
                                <span class="block font-medium text-white">PayPal</span>
                                <span class="block text-sm text-white/60">Secure online payments</span>
                            </span>
                        </label>

                        <label class="flex items-center p-4 border border-white/20 rounded-lg cursor-pointer hover:bg-white/10 transition">
                            <input type="radio" name="payment_method" value="bank_transfer"
                                   class="form-radio h-5 w-5 text-blue-400 border-white/50">
                            <span class="ml-3">
                                <span class="block font-medium text-white">Bank Transfer</span>
                                <span class="block text-sm text-white/60">Direct bank payment</span>
                            </span>
                        </label>
                    </div>
                </div>

                <!-- Credit Card Fields (shown by default) -->
                <div id="credit-card-fields" class="mb-6">
                    <div class="grid md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block font-medium mb-1 text-white">Card Number</label>
                            <input type="text" name="card_number" placeholder="1234 5678 9012 3456"
                                   class="form-input w-full bg-white/20 text-white placeholder-white/50 border-white/30 focus:border-blue-400 focus:ring focus:ring-blue-400 focus:ring-opacity-20">
                        </div>
                        <div>
                            <label class="block font-medium mb-1 text-white">Cardholder Name</label>
                            <input type="text" name="card_name" placeholder="John Doe"
                                   class="form-input w-full bg-white/20 text-white placeholder-white/50 border-white/30 focus:border-blue-400 focus:ring focus:ring-blue-400 focus:ring-opacity-20">
                        </div>
                    </div>

                    <div class="grid md:grid-cols-3 gap-4">
                        <div>
                            <label class="block font-medium mb-1 text-white">Expiry Date</label>
                            <input type="text" name="card_expiry" placeholder="MM/YY"
                                   class="form-input w-full bg-white/20 text-white placeholder-white/50 border-white/30 focus:border-blue-400 focus:ring focus:ring-blue-400 focus:ring-opacity-20">
                        </div>
                        <div>
                            <label class="block font-medium mb-1 text-white">CVV</label>
                            <input type="text" name="card_cvv" placeholder="123"
                                   class="form-input w-full bg-white/20 text-white placeholder-white/50 border-white/30 focus:border-blue-400 focus:ring focus:ring-blue-400 focus:ring-opacity-20">
                        </div>
                    </div>
                </div>

                <div class="mt-8">
                    <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-blue-600 text-white py-3 px-6 rounded-lg hover:from-blue-600 hover:to-blue-700 font-medium shadow-lg transition-all duration-300 transform hover:scale-[1.02]">
                        Complete Payment (${{ number_format($selection['amount'], 2) }})
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline ml-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
        const creditCardFields = document.getElementById('credit-card-fields');

        function toggleCardFields() {
            const selectedMethod = document.querySelector('input[name="payment_method"]:checked').value;
            creditCardFields.style.display = selectedMethod === 'credit_card' ? 'block' : 'none';

            // Toggle required attribute based on selection
            const cardInputs = creditCardFields.querySelectorAll('[required]');
            cardInputs.forEach(input => {
                input.required = selectedMethod === 'credit_card';
            });
        }

        paymentMethods.forEach(method => {
            method.addEventListener('change', toggleCardFields);
        });

        // Initialize
        toggleCardFields();
    });
</script>
@endsection
