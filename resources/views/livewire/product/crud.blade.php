<?php

use Livewire\Volt\Component;
use App\Models\Product;
use Mary\Traits\Toast;

new class extends Component {
    use Toast;

    // Estructura data de registro de un product
    public $data = [
        'category' => '',
        'name' => '',
        'description' => '',
        'price' => 0,
        'quantity' => 0,
    ];

    public $categories=[];
    // Propiedad para el modelo product
    public Product $product;

    public function mount(Product $product = null)
    {
        if ($product) {
            $this->data = $product->toArray();
            $this->product = $product;
        }

        $this->categories = \App\Models\Category::all()->pluck('name', 'id');

    }

    // Método para guardar el product
    public function save()
    {
        // Validar los datos del formulario
        $this->validate([
            'data.category' => 'required',
            'data.name' => 'required|string|max:255',
            'data.description' => 'required|string',
            'data.price' => 'required|numeric',
            'data.quantity' => 'required|numeric',
        ]);

        // Guardar los datos en la base de datos
        Product::updateOrCreate(
            ['id' => $this->product->exists ? $this->product->id : null], // Si hay ID, actualiza; si no, crea
            $this->data // Guarda todos los datos, incluida la ruta de la imagen
        );

        // Mostrar mensaje de éxito
        $this->success('Product guardado con éxito!');
    }


}; ?>

<div>
    {{-- col-span-full para que ocupe todo el ancho en dispositivos pequeños --}}
    <x-card title="Productos" shadow separator class="col-span-full">
        {{-- wire:submit.prevent="save" para evitar el envío tradicional del formulario --}}
        <x-form wire:submit="save" no-separator>
            <div class="grid grid-cols-2 gap-x-4">
                <x-input label="Título" wire:model="data.title" />
                <x-input label="Autor" wire:model="data.author" disabled />
            </div>

            <div class="grid grid-cols-2 gap-x-4">
                <x-select label="Categoría" wire:model="data.category" :options="$categories" icon="o-rectangle-stack"
                    placeholder="Selecciona una categoría" />
            </div>

            {{-- Campo oculto para la imagen --}}
            {{-- Componente de subida de archivo de MaryUI --}}
            <x-file label="Imagen" wire:model="photo" hint="Max 1MB (1024 KB)" accept="image/*"
                placeholder="Selecciona una imagen">
                {{-- Previsualización --}}
                @php
                    if ($post->exists && $post->image) {
                        // Si el post ya existe y tiene una imagen guardada en la base de datos
                        $imageUrl = Storage::disk('public')->exists($post->image)
                            ? Storage::url($post->image)
                            : asset('assets/images/empty.jpg');
                    } elseif ($photo) {
                        // Si hay una nueva imagen subida temporalmente
                        $imageUrl = $photo->temporaryUrl();
                    } else {
                        // Si no hay imagen, mostrar una imagen por defecto
                        $imageUrl = asset('assets/images/empty.jpg');
                    }
                @endphp
                <img src="{{ $imageUrl }}" class="h-40 rounded-lg object-cover" alt="Previsualización de la imagen" />
            </x-file>

            {{-- Acciones del formulario --}}
            <x-slot:actions>
                {{-- Botón de guardar --}}
                <x-button label="{{ $post->exists ? 'Actualizar Post' : 'Crear Post' }}" class="btn-primary"
                    type="submit" spinner="save" />
            </x-slot:actions>
        </x-form>
    </x-card>
</div>