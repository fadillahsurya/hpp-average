<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['Pembelian', 'Penjualan']);   
            $table->date('date');                              
            $table->decimal('qty', 18, 4);                      
            $table->decimal('price', 18, 6)->nullable();       

            $table->decimal('qty_effective', 18, 4)->nullable();   
            $table->decimal('cost', 18, 6)->nullable();           
            $table->decimal('total_cost', 22, 6)->nullable();     
            $table->decimal('qty_balance', 18, 4)->nullable();     
            $table->decimal('value_balance', 22, 6)->nullable();   
            $table->decimal('hpp', 18, 6)->nullable();             

            $table->timestamps();

            $table->index(['date', 'id']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('transactions');
    }
};
