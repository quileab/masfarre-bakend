<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'client_id',
        'category_id',
        'title',
        'notes',
        'total',
        'status',
    ];

    // Usuario admin que creó el presupuesto
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    // Usuario cliente al que va dirigido
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    // Relación con categoría
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Productos del presupuesto (relación muchos a muchos)
    public function products()
    {
        return $this->belongsToMany(Product::class, 'budget_product')
            ->withPivot('quantity', 'unit_price', 'subtotal')
            ->withTimestamps();
    }
}
