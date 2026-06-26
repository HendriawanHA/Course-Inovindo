<?php

namespace App\Services;

use App\Events\TransactionCancelled;
use App\Events\TransactionPaid;
use App\Models\Transaction;

class MidtransService
{
    public function getTransactionStatus(string $orderId): array
    {
        $status = \Midtrans\Transaction::status($orderId);

        return [
            'transaction_status' => $status->transaction_status ?? 'unknown',
            'fraud_status' => $status->fraud_status ?? null,
            'status_code' => $status->status_code ?? null,
            'payment_type' => $status->payment_type ?? null,
        ];
    }

    public function generateSnapToken(Transaction $transaction): string
    {
        if ($transaction->course_id) {
            $item = [
                'id' => $transaction->course_id,
                'price' => (int) $transaction->amount,
                'quantity' => 1,
                'name' => $transaction->course->title,
            ];
        } else {
            $item = [
                'id' => $transaction->event_id,
                'price' => (int) $transaction->amount,
                'quantity' => 1,
                'name' => $transaction->event->title,
            ];
        }

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
            'item_details' => [$item],
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
            $transaction->update(['status' => 'paid', 'paid_at' => now()]);
            TransactionPaid::dispatch($transaction, (array) $notification->response);
        } elseif ($transactionStatus === 'settlement') {
            $transaction->update(['status' => 'paid', 'paid_at' => now()]);
            TransactionPaid::dispatch($transaction, (array) $notification->response);
        } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
            $transaction->update(['status' => 'cancelled']);
            TransactionCancelled::dispatch($transaction);
        } elseif ($transactionStatus === 'pending') {
            // no action
        }

        return [
            'order_id' => $notification->order_id,
            'status' => $transactionStatus,
        ];
    }
}
