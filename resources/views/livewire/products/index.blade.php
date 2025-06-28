<?php

use App\Models\Product;
use Illuminate\Support\Collection;
use Livewire\Volt\Component;
use Mary\Traits\Toast;
use Livewire\WithPagination;
use Illuminate\Pagination\LengthAwarePaginator;

new class extends Component {
    use Toast, WithPagination;

    public string $search = '';
    public int $records_count = 0;
    public array $sortBy = ['column' => 'name', 'direction' => 'asc'];

    // Clear filters
    public function clear(): void
    {
        $this->reset();
        $this->resetPage();
        $this->success('Filters cleared.', position: 'toast-bottom');
    }

    // Delete action
    public function delete(Product $product): void
    {
        $product->delete();
        $this->warning("$product->name deleted", 'Good bye!', position: 'toast-bottom');
    }

    // Table headers
    public function headers(): array
    {
        return [
            ['key' => 'id', 'label' => '#', 'class' => 'w-1'],
            ['key' => 'name', 'label' => 'Nombre'],
            ['key' => 'category.name', 'label' => 'Categoría', 'sortable' => false],
            ['key' => 'description', 'label' => 'Descripción'],
        ];
    }

    public function products(): LengthAwarePaginator
    {
        $result = Product::with('category')
            //->query()
            ->when($this->search, fn($q) => $q->where('name', 'like', "%$this->search%"))
            ->orderBy(...array_values($this->sortBy))
            ->paginate(15);

        $this->records_count = $result->total();

        return $result;
    }

    public function with(): array
    {
        return [
            'products' => $this->products(),
            'headers' => $this->headers(),
        ];
    }

    // Reset pagination when any component property changes
    public function updated($property): void
    {
        if (!is_array($property) && $property != '') {
            $this->resetPage();
        }
    }
}; ?>

<div>
    <!-- HEADER -->
    <x-header title="Productos" separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <x-input placeholder="Search..." wire:model.live.debounce="search" clearable icon="o-magnifying-glass" />
        </x-slot:middle>
        <x-slot:actions>
            <x-badge value="{{ $records_count }}" class="badge-primary" />
            <x-button label="Nuevo" icon="o-plus" link="/product" class="btn-primary" />
        </x-slot:actions>
    </x-header>

    <!-- TABLE  -->
    <x-card>
        <x-table :headers="$headers" :rows="$products" :sort-by="$sortBy" link="product/{id}" with-pagination>
            @scope('actions', $product)
            <x-button icon="o-trash" wire:click="delete({{ $product['id'] }})" wire:confirm="Esta seguro?" spinner
                class="btn-ghost btn-sm text-red-500" />
            @endscope
        </x-table>
    </x-card>
</div>