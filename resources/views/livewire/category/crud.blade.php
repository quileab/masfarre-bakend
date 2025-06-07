<?php

use Livewire\Volt\Component;

new class extends Component {
    public $name = '';
    public $actulizando = false;
    public $categoryId = null;
    //
    public function mount(\App\Models\Category $category)
    {
        if ($category->id) {
            $this->name = $category->name;
            $this->categoryId = $category->id;
            $this->actulizando = true;
        }

    }
    public function save()
    {
        //validate category not null and not exist
        $this->validate([
            'name' => 'required|unique:categories',
        ]);
        // Save category
        if ($this->actulizando) {
            $category = \App\Models\Category::find($this->categoryId);
            $category->name = $this->name;
            $category->save();
        } else {
            \App\Models\Category::create([
                'name' => $this->name,
            ]);
        }
        return redirect('/category');
    }
}; ?>

<div>
    <x-card title="Categoria {{ $this->actulizando ? 'Actualizar' : 'Crear' }}" subtitle="agregar o editar categoria"
        shadow separator>
        <x-input label="Nombre" wire:model="name" placeholder="Nombre de la categoria" icon="o-tag">
            <x-slot:append>
                {{-- Add `join-item` to all appended elements --}}
                <x-button label="Guardar" icon="o-check" wire:click="save" class="join-item btn-success" />
            </x-slot:append>
        </x-input>
    </x-card>
</div>