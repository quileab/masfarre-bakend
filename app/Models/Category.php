<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];
    public function budgets()
    {
        return $this->hasMany(Budget::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
