<?php

namespace Database\Seeders;

use App\Models\Transaction;
use App\Services\HppCalculatorService;
use Illuminate\Database\Seeder;

class TransactionSampleSeeder extends Seeder
{
    public function run(): void
    {
        Transaction::query()->delete();

        $rows = [
            ['type'=>'Pembelian','date'=>'2021-01-01','qty'=>40,'price'=>100],
            ['type'=>'Penjualan','date'=>'2021-01-01','qty'=>20],
            ['type'=>'Penjualan','date'=>'2021-01-02','qty'=>10],
            ['type'=>'Pembelian','date'=>'2021-01-03','qty'=>20,'price'=>120],
            ['type'=>'Pembelian','date'=>'2021-01-03','qty'=>10,'price'=>110],
            ['type'=>'Penjualan','date'=>'2021-01-04','qty'=>5],
            ['type'=>'Penjualan','date'=>'2021-01-05','qty'=>8],

            ['type'=>'Pembelian','date'=>'2021-01-06','qty'=>15,'price'=>115],

            ['type'=>'Penjualan','date'=>'2021-01-07','qty'=>20],
            ['type'=>'Penjualan','date'=>'2021-01-07','qty'=>15],
            ['type'=>'Pembelian','date'=>'2021-01-08','qty'=>10,'price'=>110],
            ['type'=>'Penjualan','date'=>'2021-01-09','qty'=>5],
            ['type'=>'Penjualan','date'=>'2021-01-10','qty'=>6],
            ['type'=>'Pembelian','date'=>'2021-01-11','qty'=>4,'price'=>125],
            ['type'=>'Penjualan','date'=>'2021-01-12','qty'=>5],
        ];

        foreach ($rows as $r) {
            Transaction::create($r);
        }

        app(HppCalculatorService::class)->recalcAll();
    }
}
