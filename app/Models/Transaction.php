<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'type', 'date', 'qty', 'price',
    ];

    protected $casts = [
        'date' => 'date',
        'qty' => 'decimal:4',
        'price' => 'decimal:6',
        'qty_effective' => 'decimal:4',
        'cost' => 'decimal:6',
        'total_cost' => 'decimal:6',
        'qty_balance' => 'decimal:4',
        'value_balance' => 'decimal:6',
        'hpp' => 'decimal:6',
    ];
}
