<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPayment
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // If user is a student and hasn't paid
        if ($user->student && !$user->student->paid_term_fee) {
            return redirect()->route('payment.form')->with('error', 'You must pay your term fee to access this page.');
        }

        // If user is a teacher and hasn't paid allowance
        if ($user->teacher && !$user->teacher->paid_allowance) {
            return redirect()->route('payment.form')->with('error', 'You must pay your allowance to access this page.');
        }

        return $next($request);
    }
}
