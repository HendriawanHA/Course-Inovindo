<?php

namespace App\Http\Controllers;

use App\Filament\Resources\Transactions\TransactionResource;
use App\Models\Transaction;
use App\Services\MidtransService;
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

    public function verify(Request $request, MidtransService $midtrans)
    {
        $orderId = $request->input('order_id');
        $transaction = Transaction::where('invoice_number', $orderId)->firstOrFail();

        if ($transaction->status === 'paid') {
            return redirect()->route('courses.show', $transaction->course_id);
        }

        $transaction->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        TransactionResource::approvePaidTransaction($transaction);

        return redirect()->route('courses.show', $transaction->course_id);
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
