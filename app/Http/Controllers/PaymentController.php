<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function finish(Request $request)
    {
        $orderId = $request->get('order_id');
        $status = $request->get('transaction_status');
        $transaction = Transaction::where('invoice_number', $orderId)->first();

        return view('payment.finish', [
            'transaction' => $transaction,
            'orderId' => $orderId,
            'status' => $status,
        ]);
    }

    public function pending(Request $request)
    {
        $orderId = $request->get('order_id');
        $transaction = Transaction::where('invoice_number', $orderId)->first();

        return view('payment.pending', [
            'transaction' => $transaction,
            'orderId' => $orderId,
        ]);
    }

    public function cancel(Transaction $transaction)
    {
        abort_if($transaction->user_id !== auth()->id(), 403);

        if ($transaction->status === 'pending') {
            $transaction->update(['status' => 'cancelled']);
        }

        return redirect()->route('courses.show', $transaction->course_id)
            ->with('success', 'Pesanan dibatalkan.');
    }
}
