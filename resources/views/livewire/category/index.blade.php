<?php

use Livewire\Volt\Component;

new class extends Component {
    public $categories = [];
    public $headers = [];

    public function mount()
    {
        $this->categories = \App\Models\Category::all();
        $this->headers = [
            ['key' => 'id', 'label' => '#'],
            ['key' => 'name', 'label' => 'Categoria'],
        ];
    }

    public function delete(\App\Models\Category $categoryId)
    {
        $categoryId->delete();
        $this->categories = \App\Models\Category::all();
    }


}; ?>

<div>
    <div class="mb-4 w-full flex justify-end gap-2">
        <x-button label="Nueva" icon="o-check" class="btn-primary" link="/category/crud" />
    </div>
    <x-table :headers="$headers" :rows="$categories" striped>
        @scope('actions', $category)
        <div class="flex">
            <x-button icon="o-trash" wire:click="delete({{ $category['id'] }})" spinner class="btn-sm text-error" />
            <x-button icon="o-pencil" link="/category/{{ $category['id'] }}/edit" spinner class="btn-sm text-primary" />
        </div>
        @endscope
    </x-table>
</div>