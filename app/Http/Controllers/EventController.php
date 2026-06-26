<?php

namespace App\Http\Controllers;

use App\Events\TransactionCancelled;
use App\Events\TransactionPaid;
use App\Models\Event;
use App\Models\Transaction;
use App\Services\MidtransService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'all');
        $search = $request->get('search');

        $query = Event::query()->where('is_active', true);
        $query->when($search, function ($q) use ($search) {
            $q->where(
                'title',
                'like',
                '%' . $search . '%'
            );
        });

        if ($filter === 'upcoming') {
            $query->where(function ($q) {
                $q->where('start_time', '>', now())
                    ->orWhere(function ($q2) {
                        $q2->where('start_time', '<=', now())
                            ->where('end_time', '>=', now());
                    });
            });
        } elseif ($filter === 'past') {
            $query->where('end_time', '<', now());
        }

        $events = $query
            ->orderBy('start_time', 'desc')
            ->get();

        $featuredEvent = $events->first();
        $events = $events->skip(1);

        return view(
            'livewire.pages.courses.events',
            compact(
                'featuredEvent',
                'events',
                'filter',
                'search'
            )
        );
    }

    public function show($slug)
    {
        $event = Event::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view(
            'livewire.pages.courses.events-detail',
            compact('event')
        );
    }

    public function buy($slug): JsonResponse
    {
        $event = Event::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        if ($event->isFree()) {
            return response()->json(['error' => 'This event is free.'], 422);
        }

        $alreadyPurchased = Transaction::where('user_id', auth()->id())
            ->where('event_id', $event->id)
            ->where('status', 'paid')
            ->exists();

        if ($alreadyPurchased) {
            return response()->json(['error' => 'Already purchased.'], 422);
        }

        $pendingTransaction = Transaction::where('user_id', auth()->id())
            ->where('event_id', $event->id)
            ->where('status', 'pending')
            ->first();

        if ($pendingTransaction) {
            $midtransStatus = app(MidtransService::class)->getTransactionStatus($pendingTransaction->invoice_number);
            $transactionStatus = $midtransStatus['transaction_status'];

            if (in_array($transactionStatus, ['settlement', 'capture'])) {
                $pendingTransaction->update(['status' => 'paid', 'paid_at' => now()]);
                TransactionPaid::dispatch($pendingTransaction);

                return response()->json(['error' => 'Already purchased.'], 422);
            }

            if (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
                $pendingTransaction->update(['status' => 'cancelled']);
                TransactionCancelled::dispatch($pendingTransaction);

                $pendingTransaction = null;
            } elseif ($transactionStatus === 'pending' && $pendingTransaction->snap_token) {
                return response()->json([
                    'snap_token' => $pendingTransaction->snap_token,
                    'client_key' => config('midtrans.client_key'),
                ]);
            }
        }

        $transaction = Transaction::create([
            'user_id' => auth()->id(),
            'event_id' => $event->id,
            'invoice_number' => 'INV-' . strtoupper(Str::random(16)),
            'amount' => $event->price ?? 0,
            'status' => 'pending',
        ]);

        try {
            $snapToken = app(MidtransService::class)->generateSnapToken($transaction);
            $transaction->update(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            $transaction->update(['status' => 'cancelled']);

            return response()->json([
                'error' => 'Failed to generate payment link. Please try again.',
            ], 500);
        }

        return response()->json([
            'snap_token' => $snapToken,
            'client_key' => config('midtrans.client_key'),
        ]);
    }
}
