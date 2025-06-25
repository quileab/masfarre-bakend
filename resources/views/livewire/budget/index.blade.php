<?php

use Livewire\Volt\Component;

new class extends Component {
    public $categories = [];
    public $budgets = [];
    public $headers = [];

    public function mount()
    {
        $this->categories = \App\Models\Category::all();
        $this->budgets = \App\Models\Budget::all();
        $this->headers = [
            ['key' => 'id', 'label' => '#'],
            ['key' => 'title', 'label' => 'Presupuesto'],
            ['key' => 'client_id', 'label' => 'Cliente'],
        ];
    }

    public function delete(\App\Models\Budget $budgetId)
    {
        $budgetId->delete();
        $this->budgets = \App\Models\Budget::all();
    }


}; ?>

<div>
    <div class="mb-4 w-full flex justify-end gap-2">
        <x-button label="Nueva" icon="o-check" class="btn-primary" link="/budget/crud" />
    </div>
    <x-table :headers="$headers" :rows="$budgets" striped>
        @scope('actions', $budget)
        <div class="flex">
            <x-dropdown>
                <x-slot:trigger>
                    <x-button icon="o-trash" class="btn-sm btn-error btn-ghost" />
                </x-slot:trigger>
                <x-button label="ELIMINAR" icon="o-trash" wire:click="delete({{ $budget['id'] }})" spinner
                    class="btn-sm text-error btn-ghost" />
            </x-dropdown>
            <x-button icon="o-pencil" link="/budget/crud/{{ $budget['id'] }}" spinner
                class="btn-sm btn-ghost text-primary" />
        </div>
        @endscope
    </x-table>
</div>