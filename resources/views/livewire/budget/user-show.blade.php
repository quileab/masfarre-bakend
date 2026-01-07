<div>
    <x-header title="Presupuesto #{{ $budget->id }}">
        <x-slot:middle class="!justify-end">
            <strong>Cliente:</strong> {{ $budget->client?->name }}
        </x-slot:middle>
        <x-slot:actions>
            <strong>Total:</strong>$ {{ number_format($budget->total, 2) }}
        </x-slot:actions>
    </x-header>

    {{-- Products Table (Read-Only) --}}
    <div class="mb-4">
        <table class="table w-full">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th class="w-24">Cant.</th>
                    <th>Notas</th>
                    <th class="text-right">P/U</th>
                    <th class="text-right">Subt.</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($budget->products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->pivot->quantity }}</td>
                        <td>{{ $product->pivot->notes }}</td>
                        <td class="text-right">$ {{ number_format($product->pivot->price, 2) }}</td>
                        <td class="text-right">$ {{ number_format($product->pivot->quantity * $product->pivot->price, 2) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No hay productos en este presupuesto.</td>
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