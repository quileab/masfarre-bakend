<?php

use Livewire\Volt\Component;
use App\Models\Category;
use Mary\Traits\Toast;

new class extends Component {
    use Toast;

    public $categories = [];

    public string $search = '';
    public int $records_count = 0;
    public bool $drawer = false;
    public array $sortBy = ['column' => 'id', 'direction' => 'asc'];

    // Clear filters
    public function clear(): void
    {
        $this->reset();
        $this->resetPage();
        $this->success('Filters cleared.', position: 'toast-bottom');
    }

    public function mount()
    {
        //$this->categories = Category::all();
    }

    public function delete(Category $categoryId)
    {
        $categoryId->delete();
        $this->categories = Category::all();
    }

    // Table headers
    public function headers(): array
    {
        return [
            ['key' => 'id', 'label' => '#', 'class' => 'w-1'],
            ['key' => 'name', 'label' => 'Categoria'],
        ];
    }

    public function categories()
    {
        $result = Category::query()
            ->when($this->search, fn($q) => $q->where('name', 'like', "%$this->search%")) // Updated 'name' to 'title'
            ->orderBy(...array_values($this->sortBy))
            ->paginate(15);

        $this->records_count = $result->total();
        return $result;
    }

    public function with(): array
    {
        return [
            'categories' => $this->categories(),
            'headers' => $this->headers(),
        ];
    }

}; ?>
<div>
    <!-- HEADER -->
    <x-header title="Categorias" separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <x-input placeholder="Buscar..." wire:model.live.debounce="search" clearable icon="o-magnifying-glass" />
        </x-slot:middle>
        <x-slot:actions>
            <x-badge value="{{ $records_count }}" class="badge-primary" />
            <x-button label="Nueva" icon="o-check" class="btn-primary" link="/category" />
        </x-slot:actions>
    </x-header>

    <!-- TABLE  -->
    <x-card>
        <x-table :headers="$headers" :rows="$this->categories()" :sort-by="$sortBy" link="category/{id}">
            @scope('actions', $category)
            <x-dropdown>
                <x-slot:trigger>
                    <x-button icon="o-trash" class="text-error btn-sm hover:text-white btn-error btn-ghost" />
                </x-slot:trigger>
                <x-button label="ELIMINAR ⚠️" icon="o-trash" tooltip="No se puede deshacer"
                    wire:click="delete({{ $category['id'] }})" spinner class="btn-sm btn-error" />
            </x-dropdown>
            @endscope
        </x-table>
    </x-card>
</div>