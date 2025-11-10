@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Make a Payment</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('payment.initiate') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="amount" class="form-label">Amount (₦):</label>
            <input type="number" name="amount" class="form-control" required min="100">
        </div>
        <button type="submit" class="btn btn-primary">Pay Now</button>
    </form>
</div>
@endsection
