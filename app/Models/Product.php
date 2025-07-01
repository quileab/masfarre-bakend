<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];
    public function budgets()
    {
        return $this->belongsToMany(Budget::class, 'budget_product')
            ->withPivot('quantity', 'price', 'notes')
            ->withTimestamps();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
