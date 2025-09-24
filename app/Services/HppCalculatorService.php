<?php

namespace App\Services;

use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class HppCalculatorService
{
    public function recalcAll(bool $wrapInTransaction = true): void
    {
        $runner = function () {
            $rows = Transaction::query()
                ->orderBy('date')
                ->orderByRaw("CASE WHEN type = 'Pembelian' THEN 0 ELSE 1 END")
                ->orderBy('id')
                ->lockForUpdate()
                ->get();

            $qtyBalance   = 0.0;
            $valueBalance = 0.0;
            $hpp          = 0.0;

            foreach ($rows as $row) {
                $isBuy  = $row->type === 'Pembelian';
                $rawQty = (float) $row->qty;

                $qtyEffective = $isBuy ? $rawQty : ($rawQty > 0 ? -$rawQty : $rawQty);
                $cost = $isBuy ? (float) ($row->price ?? 0) : $hpp;

                $nextQtyBalance   = $qtyBalance + $qtyEffective;
                $nextValueBalance = $valueBalance + ($qtyEffective * $cost);

                if ($nextQtyBalance < 0) {
                    throw new \RuntimeException(
                        "Stok tidak boleh minus pada transaksi ID {$row->id} (tanggal {$row->date->format('Y-m-d')})."
                    );
                }

                $qtyBalance   = $nextQtyBalance;
                $valueBalance = $nextValueBalance;
                $hpp          = ($qtyBalance != 0.0) ? ($valueBalance / $qtyBalance) : 0.0;

                $row->qty_effective = $qtyEffective;
                $row->cost          = $cost;
                $row->total_cost    = $qtyEffective * $cost;
                $row->qty_balance   = $qtyBalance;
                $row->value_balance = $valueBalance;
                $row->hpp           = $hpp;
                $row->save();
            }
        };

        if ($wrapInTransaction) {
            DB::transaction($runner);
        } else {
            $runner(); 
        }
    }
}
