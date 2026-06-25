<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MidtransController extends Controller
{
    public function notification(Request $request, MidtransService $midtrans): \Illuminate\Http\JsonResponse
    {
        try {
            $result = $midtrans->handleNotification();

            return response()->json(['status' => 'ok', 'data' => $result]);
        } catch (\Throwable $e) {
            Log::error('Midtrans notification failed', [
                'message' => $e->getMessage(),
                'payload' => $request->all(),
            ]);

            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
