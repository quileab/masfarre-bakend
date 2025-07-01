<?php

use Livewire\Volt\Component;
use App\Models\Budget;
use Mary\Traits\Toast;

new class extends Component {

    public string $search = '';
    public int $records_count = 0;
    public bool $drawer = false;
    public array $sortBy = ['column' => 'id', 'direction' => 'asc'];

    public function delete(Budget $budgetId)
    {
        $budgetId->delete();
        //$this->budgets = Budget::all();
    }

    // Table headers
    public function headers(): array
    {
        return [
            ['key' => 'id', 'label' => '#', 'class' => 'w-1'],
            ['key' => 'name', 'label' => 'Presupuesto'],
            ['key' => 'client.name', 'label' => 'Cliente', 'sortable' => false],
            ['key' => 'total', 'label' => 'Monto'],
        ];
    }

    public function budgets()
    {
        if(auth()->user()->role != 'admin') {
            return Budget::where('client_id', auth()->user()->id)->with('client')->paginate(15);            
        }
        $result = Budget::with('client')//query()
            ->when($this->search, fn($q) => $q->where('name', 'like', "%$this->search%")) // Updated 'name' to 'title'
            ->orderBy(...array_values($this->sortBy))
            ->paginate(15);

        $this->records_count = $result->total();
        return $result;
    }

    public function with(): array
    {
        return [
            'budgets' => $this->budgets(),
            'headers' => $this->headers(),
        ];
    }

}; ?>

<div>
    <!-- HEADER -->
    <x-header title="Presupuestos" separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <x-input placeholder="Buscar..." wire:model.live.debounce="search" clearable icon="o-magnifying-glass" />
        </x-slot:middle>
        <x-slot:actions>
            <x-badge value="{{ $records_count }}" class="badge-primary" />
            <x-button label="Nuevo" icon="o-check" class="btn-primary" link="/budget" />
        </x-slot:actions>
    </x-header>

    <!-- TABLE  -->
    <x-card>
        <x-table :headers="$headers" :rows="$this->budgets()" :sort-by="$sortBy" link="budget/{id}" striped>
            @scope('cell_total', $budget)
            <p class="text-right w-full text-warning">$&nbsp;{{ number_format($budget->total, 2) }}</p>
            @endscope

            @if(auth()->user()->role == 'admin')
            @scope('actions', $budget)
            <div class="flex">
                <x-dropdown>
                    <x-slot:trigger>
                        <x-button icon="o-trash" class="btn-sm btn-error btn-ghost" />
                    </x-slot:trigger>
                    <x-button label="ELIMINAR" icon="o-trash" wire:click="delete({{ $budget['id'] }})" spinner
                        class="btn-sm text-error btn-ghost" />
                </x-dropdown>
            </div>
            @endscope
            @endif
        </x-table>
    </x-card>
</div>