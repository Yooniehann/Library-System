<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt #{{ $payment->payment_id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #000;
            background: #fff;
        }
        
        .receipt-container {
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #ccc;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #000;
            padding-bottom: 15px;
        }
        
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #000;
        }
        
        .header p {
            margin: 5px 0 0 0;
            color: #666;
        }
        
        .library-info {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .section {
            margin-bottom: 25px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        
        .section h2 {
            margin: 0 0 15px 0;
            font-size: 18px;
            color: #000;
            border-bottom: 1px solid #eee;
            padding-bottom: 8px;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        
        .info-label {
            font-weight: bold;
            color: #333;
        }
        
        .info-value {
            color: #000;
        }
        
        .amount {
            font-weight: bold;
            font-size: 18px;
            color: #28a745;
        }
        
        .status-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }
        
        .status-completed {
            background-color: #d4edda;
            color: #155724;
        }
        
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            color: #666;
            font-size: 12px;
        }
        
        @media print {
            body {
                padding: 0;
            }
            
            .receipt-container {
                border: none;
                padding: 0;
            }
            
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <div class="header">
            <h1>Asta Library - Payment Receipt</h1>
            <p>Official Payment Confirmation</p>
        </div>
        
        <div class="library-info">
            <h2>Asta Library</h2>
            <p>123 Library Street, Bookville, BC 12345</p>
            <p>Phone: (555) 123-4567 | Email: info@astalibrary.org</p>
        </div>
        
        <div class="section">
            <h2>Payment Information</h2>
            <div class="info-row">
                <span class="info-label">Receipt Number:</span>
                <span class="info-value">#{{ $payment->payment_id }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Payment Date:</span>
                <span class="info-value">{{ $payment->payment_date->format('F j, Y') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Payment Time:</span>
                <span class="info-value">{{ $payment->payment_date->format('g:i A') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Payment Status:</span>
                <span class="info-value">
                    <span class="status-badge status-{{ $payment->status }}">
                        {{ ucfirst($payment->status) }}
                    </span>
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">Payment Method:</span>
                <span class="info-value">{{ ucfirst($payment->payment_method) }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Amount Paid:</span>
                <span class="info-value amount">${{ number_format($payment->amount, 2) }}</span>
            </div>
            @if($payment->transaction_id)
            <div class="info-row">
                <span class="info-label">Transaction ID:</span>
                <span class="info-value">{{ $payment->transaction_id }}</span>
            </div>
            @endif
        </div>
        
        <div class="section">
            <h2>Member Information</h2>
            <div class="info-row">
                <span class="info-label">Member Name:</span>
                <span class="info-value">{{ Auth::user()->fullname }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Member ID:</span>
                <span class="info-value">#{{ Auth::user()->user_id }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Email:</span>
                <span class="info-value">{{ Auth::user()->email }}</span>
            </div>
        </div>
        
        @if($payment->fine)
        <div class="section">
            <h2>Fine Details</h2>
            <div class="info-row">
                <span class="info-label">Fine ID:</span>
                <span class="info-value">#{{ $payment->fine->fine_id }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Fine Type:</span>
                <span class="info-value">{{ ucfirst($payment->fine->fine_type) }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Book Title:</span>
                <span class="info-value">{{ $payment->fine->borrow->inventory->book->title }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Author:</span>
                <span class="info-value">{{ $payment->fine->borrow->inventory->book->author->fullname ?? 'Unknown Author' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Original Fine Amount:</span>
                <span class="info-value">${{ number_format($payment->fine->total_amount, 2) }}</span>
            </div>
        </div>
        @endif
        
        @if($payment->notes)
        <div class="section">
            <h2>Payment Notes</h2>
            <p>{{ $payment->notes }}</p>
        </div>
        @endif
{{--         
        <div class="footer">
            <p>Thank you for your payment. This receipt is your proof of payment.</p>
            <p>Generated on: {{ now()->format('F j, Y \a\t g:i A') }}</p>
            <p>For questions, please contact the library administration.</p>
        </div> --}}
    </div>
    
    <script>
        // Automatically print when the page loads
        window.onload = function() {
            window.print();
            
            // Close the window after printing (optional)
            setTimeout(function() {
                window.close();
            }, 500);
        };
    </script>
</body>
</html>