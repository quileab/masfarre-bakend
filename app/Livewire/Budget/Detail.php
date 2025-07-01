<?php

namespace App\Livewire\Budget;

use App\Models\Budget;
use App\Models\Product;
use App\Models\Category;
use Livewire\Component;
use Mary\Traits\Toast;

class Detail extends Component
{
    use Toast;

    public Budget $budget;
    public $products = [];
    public $categories = [];
    public $selectedProduct;
    public $quantity = 1;
    public $searchTerm = '';
    public $selectedCategoryId = '';

    public function mount(Budget $budget)
    {
        $this->budget = $budget->load('products', 'client', 'category');
        $this->categories = Category::all()->map(function ($category) {
            return ['id' => $category->id, 'name' => $category->name];
        })->toArray();
    }

    public function addProduct()
    {
        $this->validate([
            'selectedProduct' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::find($this->selectedProduct);

        if ($this->budget->products->contains($product)) {
            $this->warning("El producto ya existe en el presupuesto.");
            return;
        }

        $this->budget->products()->attach($product->id, [
            'quantity' => $this->quantity,
            'price' => $product->price,
            'notes' => ''
        ]);

        $this->budget->refresh();
        $this->recalculateTotal();
        $this->success("Producto añadido.");
    }

    public function removeProduct($productId)
    {
        $this->budget->products()->detach($productId);
        $this->budget->refresh();
        $this->recalculateTotal();
        $this->info("Producto eliminado.");
    }

    public function updateQuantity($productId, $quantity)
    {
        if (empty($quantity) || !is_numeric($quantity) || $quantity < 1) {
            $this->error("La cantidad debe ser un número mayor a 0.");
            return;
        }

        $this->budget->products()->updateExistingPivot($productId, ['quantity' => $quantity]);
        $this->budget->refresh();
        $this->recalculateTotal();
        $this->success("Cantidad actualizada.");
    }

    public function updateNotes($productId, $notes)
    {
        $this->budget->products()->updateExistingPivot($productId, ['notes' => $notes]);
        $this->budget->refresh();
        $this->info("Notas actualizadas.");
    }

    public function recalculateTotal()
    {
        $total = $this->budget->products->sum(function ($product) {
            return $product->pivot->quantity * $product->pivot->price;
        });

        $this->budget->update(['total' => $total]);
    }

    public function render()
    {
        $query = Product::query();

        if ($this->searchTerm) {
            $query->where('name', 'like', '%' . $this->searchTerm . '%');
        }

        if ($this->selectedCategoryId) {
            $query->where('category_id', $this->selectedCategoryId);
        }

        $this->products = $query->get()->map(function ($product) {
            return ['id' => $product->id, 'name' => $product->name];
        })->toArray();

        return view('livewire.budget.detail');
    }
}
