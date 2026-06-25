<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('snap_token', 255)->nullable()->after('paid_at');
            $table->string('payment_type', 50)->nullable()->after('snap_token');
            $table->string('transaction_id', 100)->nullable()->after('payment_type');
            $table->string('payment_channel', 50)->nullable()->after('transaction_id');
            $table->timestamp('settlement_time')->nullable()->after('payment_channel');
            $table->json('raw_response')->nullable()->after('settlement_time');
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn([
                'snap_token',
                'payment_type',
                'transaction_id',
                'payment_channel',
                'settlement_time',
                'raw_response',
            ]);
        });
    }
};
