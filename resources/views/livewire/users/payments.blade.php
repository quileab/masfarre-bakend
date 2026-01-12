<?php

use Livewire\Volt\Component;
use App\Models\BudgetTransaction;
use App\Models\User;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

new class extends Component {
    use WithPagination;

    public User $user;

    #[Url]
    public string $search = '';

    public array $sortBy = ['column' => 'transaction_date', 'direction' => 'desc'];

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function payments()
    {
        return BudgetTransaction::query()
            ->whereHas('budget', fn($q) => $q->where('client_id', $this->user->id))
            ->where('type', 'payment')
            ->when($this->search, fn($q) => $q->where('notes', 'like', "%$this->search%"))
            ->orderBy($this->sortBy['column'], $this->sortBy['direction'])
            ->with('budget')
            ->paginate(15);
    }

    public function headers(): array
    {
        return [
            ['key' => 'id', 'label' => '#', 'class' => 'w-1'],
            ['key' => 'transaction_date', 'label' => 'Fecha'],
            ['key' => 'budget.name', 'label' => 'Presupuesto', 'sortable' => false],
            ['key' => 'amount', 'label' => 'Monto'],
            ['key' => 'notes', 'label' => 'Notas'],
        ];
    }

    public function with(): array
    {
        return [
            'payments' => $this->payments(),
            'headers' => $this->headers(),
        ];
    }
}; ?>

<div>
    <!-- HEADER -->
    <x-header title="Pagos: {{ $user->name }}" separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <x-input placeholder="Buscar..." wire:model.live.debounce="search" clearable icon="o-magnifying-glass" />
        </x-slot:middle>
        <x-slot:actions>
             <x-button label="Volver" icon="o-arrow-left" link="/users" class="btn-ghost" />
        </x-slot:actions>
    </x-header>

    <!-- TABLE  -->
    <x-card>
        <x-table :headers="$headers" :rows="$payments" :sort-by="$sortBy" striped>
            @scope('cell_transaction_date', $payment)
                {{ $payment->transaction_date?->format('d/m/Y') }}
            @endscope
            @scope('cell_amount', $payment)
                <span class="text-success font-bold">$ {{ number_format($payment->amount, 2) }}</span>
            @endscope
        </x-table>
    </x-card>
</div>