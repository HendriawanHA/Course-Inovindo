<?php

namespace App\Services;

use App\Models\Transaction;

class MidtransService
{
    public function generateSnapToken(Transaction $transaction): string
    {
        $params = [
            'transaction_details' => [
                'order_id' => $transaction->invoice_number,
                'gross_amount' => (int) $transaction->amount,
            ],
            'customer_details' => [
                'first_name' => $transaction->user->name,
                'email' => $transaction->user->email,
                'phone' => $transaction->user->phone ?? '',
            ],
            'item_details' => [
                [
                    'id' => $transaction->course_id,
                    'price' => (int) $transaction->amount,
                    'quantity' => 1,
                    'name' => $transaction->course->title,
                ],
            ],
            'callbacks' => [
                'finish' => route('payment.finish'),
                'unfinish' => route('payment.pending'),
                'error' => route('payment.finish'),
            ],
        ];

        return \Midtrans\Snap::getSnapToken($params);
    }

    public function handleNotification(): array
    {
        $notification = new \Midtrans\Notification();

        $transaction = Transaction::where('invoice_number', $notification->order_id)->firstOrFail();

        $transactionStatus = $notification->transaction_status;
        $fraudStatus = $notification->fraud_status;

        $transaction->update([
            'transaction_id' => $notification->transaction_id,
            'payment_type' => $notification->payment_type,
            'payment_channel' => $notification->payment_channel ?? null,
            'settlement_time' => $notification->settlement_time ?? null,
            'raw_response' => $notification->response,
        ]);

        if ($transactionStatus === 'capture' && $fraudStatus === 'accept') {
            $this->markAsPaid($transaction);
        } elseif ($transactionStatus === 'settlement') {
            $this->markAsPaid($transaction);
        } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
            $transaction->update(['status' => 'cancelled']);
        } elseif ($transactionStatus === 'pending') {
            // no action
        }

        return [
            'order_id' => $notification->order_id,
            'status' => $transactionStatus,
        ];
    }

    private function markAsPaid(Transaction $transaction): void
    {
        $transaction->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        \App\Filament\Resources\Transactions\TransactionResource::approvePaidTransaction($transaction);
    }
}
