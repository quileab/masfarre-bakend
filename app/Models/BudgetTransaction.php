<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetTransaction extends Model
{
    protected $guarded = [];

    protected $casts = [
        'transaction_date' => 'datetime',
        'amount' => 'decimal:2',
    ];

    public function budget()
    {
        return $this->belongsTo(Budget::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
