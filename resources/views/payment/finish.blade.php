@extends('layouts.app')

@section('title', 'Hasil Pembayaran')

@section('content')
    <div class="flex min-h-[60vh] flex-col items-center justify-center text-center">
        @if ($status === 'settlement' || $status === 'capture')
            <div class="mx-auto mb-4 flex size-16 items-center justify-center rounded-full bg-emerald-100 dark:bg-emerald-500/15">
                <svg class="size-8 text-emerald-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Pembayaran Berhasil</h1>
            <p class="mt-2 text-gray-500 dark:text-gray-400">
                Transaksi <span class="font-mono text-sm">{{ $orderId }}</span> telah berhasil dibayar.
            </p>
            @if ($transaction)
                @php
                    $continueUrl = $transaction->event_id
                        ? route('events.show', $transaction->event->slug)
                        : route('courses.show', $transaction->course_id);
                    $continueLabel = $transaction->event_id ? 'Lihat Event' : 'Mulai Belajar';
                @endphp
                <a
                    href="{{ $continueUrl }}"
                    class="mt-6 inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-500"
                >
                    {{ $continueLabel }}
                </a>
            @endif
        @elseif ($status === 'pending')
            <div class="mx-auto mb-4 flex size-16 items-center justify-center rounded-full bg-amber-100 dark:bg-amber-500/15">
                <svg class="size-8 text-amber-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Menunggu Pembayaran</h1>
            <p class="mt-2 text-gray-500 dark:text-gray-400">
                Pembayaran untuk <span class="font-mono text-sm">{{ $orderId }}</span> masih diproses. Silakan selesaikan pembayaran Anda.
            </p>
        @else
            <div class="mx-auto mb-4 flex size-16 items-center justify-center rounded-full bg-red-100 dark:bg-red-500/15">
                <svg class="size-8 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Pembayaran Gagal</h1>
            <p class="mt-2 text-gray-500 dark:text-gray-400">
                Transaksi <span class="font-mono text-sm">{{ $orderId }}</span> tidak berhasil. Silakan coba lagi.
            </p>
            @if ($transaction)
                <a
                    href="{{ route('courses.index') }}"
                    class="mt-6 inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-500"
                >
                    Kembali ke Course
                </a>
            @endif
        @endif

        <a href="{{ route('home') }}" class="mt-4 text-sm text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
            &larr; Kembali ke Home
        </a>
    </div>
@endsection
