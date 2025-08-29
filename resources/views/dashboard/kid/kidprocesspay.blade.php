<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Process Payment | Library System</title>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
body { background: #0f172a; color: #fff; font-family: 'Open Sans', sans-serif; }
.card { background: #0f172a; border-radius: 1rem; padding: 2rem; max-width: 500px; margin: 5rem auto; box-shadow: 0 0 15px rgba(0,0,0,0.5); }
.btn { padding: 0.5rem 1.5rem; border-radius: 0.5rem; font-weight: 500; cursor: pointer; transition: background 0.2s; text-align: center; }
.btn-pay { background: #FF9F1C; color: #000; }
.btn-pay:hover { background: #FF8C00; }
.btn-cancel { background: #6b7280; color: #fff; }
.btn-cancel:hover { background: #4b5563; }
.btn-back { background: #4b5563; color: #fff; margin-bottom: 1rem; display: inline-block; }
.btn-back:hover { background: #6b7280; }
.alert { padding: 0.75rem 1rem; border-radius: 0.5rem; margin-bottom: 1rem; }
.alert-success { background-color: #16a34a; color: #fff; }
</style>
</head>
<body>

<div class="card">

    <!-- Back Button -->
    <a href="{{ route('kid.kidfinepay.index') }}" class="btn btn-back">
        <i class="fas fa-arrow-left"></i> Back
    </a>

    <!-- Flash Message -->
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        </div>
    @endif

    <h1 class="text-2xl font-bold mb-4 text-yellow-400 flex items-center gap-2">
        <i class="fas fa-credit-card"></i> Process Payment
    </h1>

    <p class="mb-2"><strong>Fine ID:</strong> #{{ $fine->fine_id }}</p>
    <p class="mb-2"><strong>Amount:</strong> ${{ number_format($fine->total_amount, 2) }}</p>
    <p class="mb-4"><strong>Status:</strong>
        @if($fine->status === 'paid')
            <span class="text-green-300 font-semibold">Paid</span>
        @else
            <span class="text-red-400 font-semibold">Unpaid</span>
        @endif
    </p>

    @if($fine->status != 'paid')
    <form action="{{ route('kid.kidfines.pay', $fine->fine_id) }}" method="POST">
        @csrf
        <div class="flex gap-4">
            <button type="submit" class="btn btn-pay flex-1">
                <i class="fas fa-credit-card"></i> Pay
            </button>
            <a href="{{ route('kid.kidfinepay.index') }}" class="btn btn-cancel flex-1">Cancel</a>
        </div>
    </form>
    @else
        <p class="text-green-300 font-semibold">This fine is already paid.</p>
    @endif

</div>

</body>
</html>
