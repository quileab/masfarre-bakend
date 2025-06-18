<?php

use Livewire\Volt\Component;
use App\Models\Product;
use Mary\Traits\Toast;

new class extends Component {
    use Toast;

    // Estructura data de registro de un product
    public $data = [
        'id' => null,
        'category_id' => '',
        'name' => '',
        'description' => '',
        'price' => 0,
        'quantity' => 0,
    ];

    public $product;
    public $categories = [];
    // // Propiedad para el modelo product
    // public Product $product;

    public function mount($product = null)
    {
        $this->product = Product::find($product);
        if ($this->product) {
            $this->data = $this->product->toArray();
            //$this->product = $product;
        }
        $this->categories = \App\Models\Category::select('id', 'name')->get();
    }

    // Método para guardar el product
    public function save()
    {
        // Validar los datos del formulario
        $this->validate([
            'data.category_id' => 'required',
            'data.name' => 'required|string|max:255',
            'data.description' => 'required|string',
            'data.price' => 'required|numeric|gt:0',
            'data.quantity' => 'required|numeric|gt:0',
        ]);

        // Guardar los datos en la base de datos
        $result = Product::updateOrCreate(
            ['id' => $this->data['id'] ? $this->product->id : null], // Si hay ID, actualiza; si no, crea
            $this->data // Guarda todos los datos, incluida la ruta de la imagen
        );
        // Mostrar mensaje de éxito
        $this->success('Guardado con éxito!', redirectTo: '/products');
    }

}; ?>

<div>
    <x-card title="Productos" shadow separator class="col-span-full">
        {{-- wire:submit.prevent="save" para evitar el envío tradicional del formulario --}}
        <x-form wire:submit.prevent="save" no-separator>
            <div class="grid grid-cols-2 gap-x-4">
                <x-select label="Categoría" :options="$categories" icon="o-rectangle-stack"
                    wire:model="data.category_id" placeholder="Selecciona una categoría" />
            </div>
            <x-input label="Nombre" wire:model="data.name" />
            <x-textarea label="Descripción" wire:model="data.description" placeholder="Sólo el texto necesario ..."
                hint="Max 1000 chars" rows="5" />
            <div class="grid grid-cols-2 gap-x-4">
                <x-input label="Precio" wire:model="data.price" />
                <x-input label="Cantidad" wire:model="data.quantity" />
            </div>

            <x-slot:actions>
                <x-button label="{{ $product ? 'Actualizar' : 'Crear' }}" class="btn-primary" type="submit"
                    spinner="save" />
            </x-slot:actions>
        </x-form>
    </x-card>
</div>