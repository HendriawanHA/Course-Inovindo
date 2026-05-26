<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Transaction;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    public function buy(Course $course)
    {
        $user = auth()->user();

        // Course gratis
        if ($course->isFree()) {
            return back()->with('error', 'This course is free.');
        }

        // Sudah beli
        $alreadyPurchased = Transaction::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->where('status', 'paid')
            ->exists();

        if ($alreadyPurchased) {
            return back()->with('success', 'You already purchased this course.');
        }

        // Cek pending sebelumnya
        $pendingTransaction = Transaction::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->where('status', 'pending')
            ->first();

        if ($pendingTransaction) {
            return back()->with('warning', 'Purchase already pending approval.');
        }

        // Buat transaksi
        Transaction::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'invoice_number' => 'INV-' . strtoupper(Str::random(10)),
            'amount' => $course->price,
            'status' => 'pending',
        ]);

        return back()->with(
            'success',
            'Purchase request created successfully.'
        );
    }
}
