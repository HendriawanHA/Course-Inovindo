@extends('layouts.app')

@section('title', 'Pembayaran Pending')

@section('content')
    <div class="flex min-h-[60vh] flex-col items-center justify-center text-center">
        <div class="mx-auto mb-4 flex size-16 items-center justify-center rounded-full bg-amber-100 dark:bg-amber-500/15">
            <svg class="size-8 text-amber-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
        </div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Pembayaran Pending</h1>
        <p class="mt-2 text-gray-500 dark:text-gray-400">
            Transaksi <span class="font-mono text-sm">{{ $orderId }}</span> menunggu pembayaran.
        </p>
        <a href="{{ route('home') }}" class="mt-4 text-sm text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
            &larr; Kembali ke Home
        </a>
    </div>
@endsection
