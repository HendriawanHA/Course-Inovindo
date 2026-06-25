<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Transaction;
use App\Services\MidtransService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $transactions = Transaction::with('course')
            ->where('user_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('transactions.index', compact('transactions'));
    }

    public function buy(Course $course): RedirectResponse|JsonResponse
    {
        $user = auth()->user();

        if ($course->isFree()) {
            return back()->with('error', 'This course is free.');
        }

        $alreadyPurchased = Transaction::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->where('status', 'paid')
            ->exists();

        if ($alreadyPurchased) {
            return back()->with('success', 'You already purchased this course.');
        }

        $pendingTransaction = Transaction::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->where('status', 'pending')
            ->first();

        if ($pendingTransaction) {
            if ($pendingTransaction->snap_token) {
                return response()->json([
                    'snap_token' => $pendingTransaction->snap_token,
                    'client_key' => config('midtrans.client_key'),
                ]);
            }

            try {
                $snapToken = app(MidtransService::class)->generateSnapToken($pendingTransaction);
                $pendingTransaction->update(['snap_token' => $snapToken]);

                return response()->json([
                    'snap_token' => $snapToken,
                    'client_key' => config('midtrans.client_key'),
                ]);
            } catch (\Exception $e) {
                $pendingTransaction->update(['status' => 'cancelled']);
            }
        }

        $transaction = Transaction::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'invoice_number' => 'INV-' . strtoupper(Str::random(16)),
            'amount' => $course->price,
            'status' => 'pending',
        ]);

        $snapToken = app(MidtransService::class)->generateSnapToken($transaction);

        $transaction->update(['snap_token' => $snapToken]);

        return response()->json([
            'snap_token' => $snapToken,
            'client_key' => config('midtrans.client_key'),
        ]);
    }
}
