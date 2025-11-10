@extends('layouts.app')

@section('content')
<div class="container text-center mt-5">
    <h2 class="text-success">✅ Payment Successful!</h2>
    <p>Amount Paid: <strong>₦{{ number_format($amount, 2) }}</strong></p>
    <p>Reference: <strong>{{ $reference }}</strong></p>
    <a href="{{ route('dashboard') }}" class="btn btn-secondary mt-3">Back to Dashboard</a>
</div>
@endsection
