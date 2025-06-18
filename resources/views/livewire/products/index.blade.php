<?php

use Livewire\Volt\Component;

new class extends Component {
    public $products = [];
    public $headers = [];

    public function mount()
    {
        $this->products = \App\Models\Product::all();
        $this->headers = [
            ['key' => 'id', 'label' => '#'],
            ['key' => 'name', 'label' => 'Nombre'],
            ['key' => 'category', 'label' => 'Categoria'],
        ];
    }

    public function delete(\App\Models\Product $productId)
    {
        $productId->delete();
        $this->products = \App\Models\Product::all();
    }


}; ?>

<div>
    <div class="mb-4 w-full flex justify-end gap-2">
        <x-button label="AGREGAR" icon="o-plus" class="btn-primary" link="/products/crud" />
    </div>
    <x-table :headers="$headers" :rows="$products" striped>
        @scope('actions', $product)
        <div class="flex">
            <x-dropdown>
                <x-slot:trigger>
                    <x-button icon="o-trash" class="btn-error btn-ghost" />
                </x-slot:trigger>
                <x-button label="ELIMINAR" icon="o-trash" wire:click="delete({{ $product['id'] }})" spinner
                    class="btn-sm text-error btn-ghost" />
            </x-dropdown>
            <x-button icon="o-pencil" link="/products/crud/{{ $product['id'] }}" spinner class="btn-sm text-primary" />
        </div>
        @endscope
    </x-table>
</div>