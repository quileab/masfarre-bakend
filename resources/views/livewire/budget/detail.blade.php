<div>
    <x-header title="Presupuesto #{{ $budget->id }}">
        <x-slot:middle class="!justify-end">
            <strong>Cliente:</strong> {{ $budget->client?->name }}
        </x-slot:middle>
        <x-slot:actions>
            <strong>Total:</strong>$ {{ number_format($budget->total, 2) }}
        </x-slot:actions>
    </x-header>

    {{-- Add Product Form --}}
    <x-card>
        {{-- Search and Filter --}}
        <div class="grid grid-cols-2 gap-x-2">
            <x-input label="Buscar por nombre" wire:model.live="searchTerm" placeholder="Buscar productos..." />
            <x-select label="Categoría" :options="$categories" wire:model.live="selectedCategoryId"
                placeholder="Todas las categorías" />
        </div>

        <div class="flex items-end gap-2">
            <div class="flex-grow">
                <x-select label="Producto" :options="$products" wire:model="selectedProduct"
                    placeholder="Selecciona un producto" />
            </div>
            <div>
                <x-input label="Cantidad" type="number" wire:model="quantity" min="1" />
            </div>
            <div>
                <x-button label="Añadir" wire:click="addProduct" class="btn-primary" spinner />
            </div>
        </div>
    </x-card>

    {{-- Products Table --}}
    <div class="mb-4">
        <table class="table w-full">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th class="w-24">Cant.</th>
                    <th>Notas</th>
                    <th class="text-right">P/U</th>
                    <th class="text-right">Subt.</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($budget->products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>
                            <x-input type="number" value="{{ $product->pivot->quantity }}"
                                wire:change="updateQuantity({{ $product->id }}, $event.target.value)" class="input-sm" />
                        </td>
                        <td>
                            <x-input type="text" value="{{ $product->pivot->notes }}"
                                wire:change="updateNotes({{ $product->id }}, $event.target.value)" class="input-sm" />
                        </td>
                        <td class="text-right">$ {{ number_format($product->pivot->price, 2) }}</td>
                        <td class="text-right">$ {{ number_format($product->pivot->quantity * $product->pivot->price, 2) }}
                        </td>
                        <td>
                            <x-button icon="o-trash" wire:click="removeProduct({{ $product->id }})" spinner
                                class="btn-sm btn-error btn-ghost" />
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No hay productos en este presupuesto.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="my-8">
        <livewire:budget.wallet :budget="$budget" />
    </div>

    <div class="mt-4">
        <x-button label="Volver" link="/budgets" icon="o-arrow-left" class="btn-primary" />
    </div>
</div>