<?php

namespace App\Http\Controllers;

use App\Events\TransactionCancelled;
use App\Events\TransactionPaid;
use App\Models\Transaction;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function finish(Request $request)
    {
        $orderId = $request->get('order_id');
        $status = $request->get('transaction_status');
        $transaction = Transaction::with(['course', 'event'])->where('invoice_number', $orderId)->first();

        if ($transaction && $transaction->status === 'pending' && in_array($status, ['settlement', 'capture'])) {
            $transaction->update(['status' => 'paid', 'paid_at' => now()]);
            TransactionPaid::dispatch($transaction);
        }

        return view('payment.finish', [
            'transaction' => $transaction,
            'orderId' => $orderId,
            'status' => $status,
        ]);
    }

    public function pending(Request $request)
    {
        $orderId = $request->get('order_id');
        $transaction = Transaction::with(['course', 'event'])->where('invoice_number', $orderId)->first();

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
            TransactionCancelled::dispatch($transaction);
        }

        $route = $transaction->event_id
            ? route('events.show', $transaction->event->slug)
            : route('courses.show', $transaction->course_id);

        return redirect($route)->with('success', 'Pesanan dibatalkan.');
    }
}
