<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Models\Transaction;
use App\Services\HppCalculatorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $q = Transaction::query();

        if ($request->filled('from')) {
            $q->whereDate('date', '>=', $request->query('from'));
        }
        if ($request->filled('to')) {
            $q->whereDate('date', '<=', $request->query('to'));
        }

        $items = $q
            ->orderBy('date')
            ->orderByRaw("CASE WHEN type = 'Pembelian' THEN 0 ELSE 1 END") 
            ->orderBy('id')
            ->get();

        return response()->json(['data' => $items]);
    }


    public function store(StoreTransactionRequest $request, HppCalculatorService $hpp): JsonResponse
    {
        try {
            DB::transaction(function () use ($request, $hpp) {
                Transaction::create($request->validated());
                $hpp->recalcAll(false);
            });

            return response()->json(['message' => 'Created'], 201);
        } catch (\RuntimeException $e) {
            return response()->json([
                'message' => 'Validasi stok gagal',
                'error'   => $e->getMessage(),
            ], 422);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function update(UpdateTransactionRequest $request, Transaction $transaction, HppCalculatorService $hpp): JsonResponse
    {
        try {
            DB::transaction(function () use ($request, $transaction, $hpp) {
                $transaction->update($request->validated());
                $hpp->recalcAll(false);
            });

            return response()->json(['message' => 'Updated']);
        } catch (\RuntimeException $e) {
            return response()->json([
                'message' => 'Validasi stok gagal',
                'error'   => $e->getMessage(),
            ], 422);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    // 3) REMOVE
    public function destroy(Transaction $transaction, HppCalculatorService $hpp): JsonResponse
    {
        try {
            DB::transaction(function () use ($transaction, $hpp) {
                $transaction->delete();
                $hpp->recalcAll(false); 
            });

            return response()->json(['message' => 'Deleted']);
        } catch (\RuntimeException $e) {
            return response()->json([
                'message' => 'Validasi stok gagal',
                'error'   => $e->getMessage(),
            ], 422);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

}
