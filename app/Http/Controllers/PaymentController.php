<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    public function showForm()
    {
        return view('payment.form');
    }

    public function initiate(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:100',
        ]);

        $user = Auth::user();

        $response = Http::withToken(env('PAYSTACK_SECRET_KEY'))
            ->post(env('PAYSTACK_PAYMENT_URL') . '/transaction/initialize', [
                'email' => $user->email,
                'amount' => $request->amount * 100, // Paystack expects kobo
                'callback_url' => route('payment.callback'),
            ]);

        $data = $response->json();

        if ($data['status'] && isset($data['data']['authorization_url'])) {
            return redirect($data['data']['authorization_url']);
        }

        return back()->with('error', 'Payment initialization failed. Try again.');
    }

    public function callback(Request $request)
{
    $reference = $request->query('reference');

    if (!$reference) {
        return redirect()->route('dashboard')->with('error', 'No payment reference found.');
    }

    $response = Http::withToken(env('PAYSTACK_SECRET_KEY'))
        ->get(env('PAYSTACK_PAYMENT_URL') . "/transaction/verify/{$reference}");

    $data = $response->json();

    if ($data['status'] && $data['data']['status'] === 'success') {
        $user = Auth::user();

        // ✅ Mark as paid depending on role
        if ($user->role === 'student' && $user->student) {
            $user->student->update(['paid_term_fee' => true]);
        } elseif ($user->role === 'teacher' && $user->teacher) {
            $user->teacher->update(['paid_allowance' => true]);
        }

        return redirect()->route('dashboard')->with('success', 'Payment successful! Your account is now active.');
    }

    return redirect()->route('dashboard')->with('error', 'Payment verification failed.');
}

}
