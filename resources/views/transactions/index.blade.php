@extends('layouts.app')

@section('title', 'My Transactions')

@section('content')
<div class="p-4 md:p-8 max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">My Transactions</h1>

    @if ($transactions->isEmpty())
        <div class="text-center py-16 text-zinc-400">
            <p class="text-lg">No transactions yet</p>
            <a href="{{ route('courses.index') }}" class="text-indigo-600 hover:underline mt-2 inline-block">
                Browse courses
            </a>
        </div>
    @else
        <div class="space-y-3">
            @foreach ($transactions as $transaction)
                @php
                    $isEvent = $transaction->event_id !== null;
                    $status = $transaction->status;
                    $title = $isEvent ? $transaction->event?->title : $transaction->course?->title;
                    $thumbnail = $isEvent ? $transaction->event?->thumbnail_url : $transaction->course?->thumbnail_url;
                    $showUrl = $isEvent ? route('events.show', $transaction->event?->slug) : route('courses.show', $transaction->course_id);
                    $ctaText = $isEvent ? ($status === 'paid' ? 'Lihat Event' : 'Bayar') : ($status === 'paid' ? 'Mulai Belajar' : 'Bayar');
                @endphp
                <div class="flex items-center gap-4 rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-800 dark:bg-zinc-900">
                    <img
                        src="{{ $thumbnail }}"
                        class="h-14 w-20 rounded-lg object-cover flex-shrink-0">

                    <div class="flex-1 min-w-0">
                        <p class="font-semibold truncate">
                            <a href="{{ $showUrl }}" wire:navigate class="hover:text-indigo-600">
                                {{ $title }}
                            </a>
                        </p>
                        <p class="text-xs text-zinc-400 font-mono mt-0.5">{{ $transaction->invoice_number }}</p>
                        <p class="text-sm text-zinc-500 mt-0.5">
                            Rp{{ number_format($transaction->amount, 0, ',', '.') }}
                            &middot;
                            {{ $transaction->created_at->isoFormat('D MMM YYYY') }}
                        </p>
                    </div>

                    <div class="flex items-center gap-3 flex-shrink-0">
                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full
                            @if ($status === 'paid') bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400
                            @elseif ($status === 'pending') bg-amber-100 text-amber-700 dark:bg-amber-500/15 dark:text-amber-400
                            @else bg-zinc-100 text-zinc-500 dark:bg-zinc-800 dark:text-zinc-400 @endif
                        ">
                            {{ ucfirst($status) }}
                        </span>

                        @if ($status === 'paid')
                            <a href="{{ $showUrl }}"
                               class="rounded-lg bg-indigo-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-indigo-500">
                                {{ $ctaText }}
                            </a>
                        @elseif ($status === 'pending')
                            <a href="{{ $showUrl }}"
                               class="rounded-lg border border-indigo-600 px-3 py-1.5 text-xs font-semibold text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-950">
                                {{ $ctaText }}
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $transactions->links() }}
        </div>
    @endif
</div>
@endsection
