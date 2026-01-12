<?php

use Livewire\Volt\Component;
use App\Models\Budget;
use App\Models\Category;
use App\Models\Product;
use Mary\Traits\Toast;
use Livewire\Attributes\Computed;
use App\Http\Controllers\PdfController;

new class extends Component {
    use Toast;

    // Header Data
    public $data = [
        'id' => null,
        'event_type_id' => 1,
        'name' => '',
        'date' => '',
        'notes' => '',
        'total' => 0,
        'status' => 'draft',
        'client_id' => null,
        'admin_id' => null,
    ];

    public $statuses = [
        ['id' => 1, 'name' => 'draft', 'label' => 'Borrador'],
        ['id' => 2, 'name' => 'sent', 'label' => 'Enviado'],
        ['id' => 3, 'name' => 'approved', 'label' => 'Aprobado'],
        ['id' => 4, 'name' => 'rejected', 'label' => 'Rechazado'],
    ];

    public $eventtypes = [];
    public $client = [];

    // Details Data
    public $categories = [];
    public $productOptions = [];
    // public $budgetProducts = []; // Removed: Now using Computed Property

    public $selectedCategoryId = null;
    public $selectedProduct = null;
    public $quantity = 1;

    public function mount(Budget $budget)
    {
        if (auth()->user()->role != 'admin') {
            return redirect()->back();
        }

        $this->categories = Category::all();
        $this->eventtypes = \App\Models\EventType::select('id', 'name')->get();
        $this->searchProducts();

        if (!$budget->exists) {
            $this->client = \App\Models\User::getSessionUser();
            $this->data = [
                'id' => null,
                'admin_id' => null,
                'client_id' => null,
                'name' => '',
                'date' => date('Y-m-d', strtotime('+30 days')),
                'event_type_id' => 1,
                'notes' => '',
                'status' => 'draft',
                'total' => 0,
            ];
        } else {
            $this->loadBudget($budget);
        }
    }

    public function loadBudget(Budget $budget)
    {
        $this->data = $budget->toArray();
        $this->client = $budget->client;
        // $this->budgetProducts = ... // Removed: Computed property handles this
    }

    #[Computed]
    public function budgetProducts()
    {
        if (!$this->data['id'])
            return [];

        return Budget::find($this->data['id'])
            ->products()
            ->withPivot('quantity', 'price', 'notes')
            ->get();
    }

    // Filter products for the dropdown
    public function updatedSelectedCategoryId()
    {
        $this->searchProducts();
    }

    public function searchProducts(string $value = '')
    {
        $query = Product::query();

        if ($this->selectedCategoryId) {
            $query->where('category_id', $this->selectedCategoryId);
        }

        if ($value) {
            $query->where('name', 'like', '%' . $value . '%');
        }

        // Keep selected option
        $selected = $this->selectedProduct ? Product::where('id', $this->selectedProduct)->get() : collect();

        $this->productOptions = $query->take(20)->get()->merge($selected);
    }

    public function updateOrCreate()
    {
        $this->data['admin_id'] = auth()->user()->id;
        $this->data['client_id'] = $this->client['id'];

        $validated = $this->validate([
            'data.id' => 'nullable',
            'data.admin_id' => 'exists:users,id',
            'data.client_id' => 'exists:users,id',
            'data.name' => 'required|string|max:100',
            'data.date' => 'required|date',
            'data.event_type_id' => 'required|exists:event_types,id',
            'data.notes' => 'nullable|string',
            'data.total' => 'numeric',
            'data.status' => 'required',
        ]);

        $result = Budget::updateOrCreate(
            ['id' => $validated['data']['id']],
            $validated['data']
        );

        $this->loadBudget($result);
        $this->success('Encabezado guardado! Ahora puedes agregar detalles.');
    }

    // --- Details Logic ---

    public function addProduct()
    {
        $this->validate([
            'selectedProduct' => 'required',
            'quantity' => 'required|numeric|min:1',
        ]);

        $budget = Budget::find($this->data['id']);
        $product = Product::find($this->selectedProduct);

        if ($budget->products()->where('product_id', $product->id)->exists()) {
            $this->error('El producto ya está en el presupuesto.');
            return;
        }

        $budget->products()->attach($product->id, [
            'quantity' => $this->quantity,
            'price' => $product->price,
            'notes' => ''
        ]);

        $this->recalculateTotal($budget);
        $this->loadBudget($budget);
        $this->quantity = 1;
        $this->selectedProduct = null;
        $this->success('Producto agregado.');
    }

    public function removeProduct($productId)
    {
        $budget = Budget::find($this->data['id']);
        $budget->products()->detach($productId);
        $this->recalculateTotal($budget);
        $this->loadBudget($budget);
    }

    public function updateQuantity($productId, $quantity)
    {
        if ($quantity < 1)
            return;
        $budget = Budget::find($this->data['id']);
        $budget->products()->updateExistingPivot($productId, ['quantity' => $quantity]);
        $this->recalculateTotal($budget);
        $this->loadBudget($budget);
    }

    public function updateNotes($productId, $notes)
    {
        $budget = Budget::find($this->data['id']);
        $budget->products()->updateExistingPivot($productId, ['notes' => $notes]);
        // No need to recalculate total for notes, just reload
        $this->loadBudget($budget);
    }

    protected function recalculateTotal(Budget $budget)
    {
        $total = 0;
        foreach ($budget->products as $prod) {
            $total += $prod->pivot->quantity * $prod->pivot->price;
        }
        $budget->update(['total' => $total]);
    }

    public function approve()
    {
        $budget = Budget::find($this->data['id']);
        $budget->update(['status' => 'approved']);
        
        try {
            PdfController::generateBudgetPdf($budget);
            $this->success('Presupuesto aprobado y PDF generado!');
        } catch (\Exception $e) {
            $this->warning('Presupuesto aprobado, pero hubo un error generando el PDF: ' . $e->getMessage());
        }

        $this->loadBudget($budget);
    }
}; ?>

<div>
    {{-- Header Section --}}
    <x-card title="Presupuesto: {{ $this->client['name'] ?? 'n/a' }}" shadow separator class="col-span-full mb-5">
        @if($client == null)
            <x-alert title="No se ha seleccionado un cliente" icon="o-exclamation-triangle" class="alert-error">
                <x-slot:actions>
                    <x-button label="Buscar" icon="o-user" link="/users" class="btn-primary" />
                </x-slot:actions>
            </x-alert>
        @endif

        <x-form wire:submit="updateOrCreate">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="md:col-span-3">
                    <x-input label="Nombre del Presupuesto" wire:model="data.name" />
                </div>
                <div class="md:col-span-1">
                    <x-input label="Total" wire:model="data.total" prefix="$" money readonly />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                <x-select label="Tipo de Evento" wire:model="data.event_type_id" :options="$eventtypes" icon="o-tag" />
                <x-input label="Fecha" wire:model="data.date" type="date" />
                <x-select label="Estado" wire:model="data.status" :options="$statuses" option-label="label"
                    option-value="name" />
            </div>
            <x-textarea label="Notas" wire:model="data.notes" placeholder="Sólo el texto necesario ..." rows="3"
                class="mt-4" />

            @if ($client)
                <x-slot:actions>
                    <x-button label="Volver" icon="o-x-mark" class="btn-secondary" link="/budgets" />
                    <x-button label="{{ $data['id'] ? 'Actualizar Encabezado' : 'Crear y Continuar' }}" icon="o-check"
                        class="btn-primary" type="submit" spinner="updateOrCreate" />
                </x-slot:actions>
            @endif
        </x-form>
    </x-card>

    {{-- Details Section (Only Visible after Create) --}}
    @if ($this->data['id'])
        <x-card title="Detalle de Productos" shadow separator class="col-span-full animate-fade-in-up">
            <x-slot:menu>
                <div class="flex items-center gap-4">
                    <span class="text-lg font-bold text-success">Total: $ {{ number_format($data['total'], 2) }}</span>
                    <x-button label="Aprobar" icon="o-check" class="btn-success btn-sm" 
                        wire:click="approve"
                        wire:confirm="¿Seguro que deseas aprobar este presupuesto?" 
                        spinner="approve" />
                </div>
            </x-slot:menu>

            {{-- Search and Add Tools --}}
            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 mb-4 items-end">
                <div class="md:col-span-4">
                    <x-select label="Categoría" :options="$categories" wire:model.live="selectedCategoryId"
                        placeholder="Todas" />
                </div>
                <div class="md:col-span-6">
                    <x-choices label="Producto" wire:model="selectedProduct" :options="$productOptions"
                        search-function="searchProducts" single searchable min-chars="2" />
                </div>
                <div class="md:col-span-1">
                    <x-input label="Cant." type="number" wire:model="quantity" min="1" />
                </div>
                <div class="md:col-span-1">
                    <x-button label="+" wire:click="addProduct" class="btn-primary w-full" spinner="addProduct" />
                </div>
            </div>

            {{-- Products Table --}}
            <div class="overflow-x-auto">
                <table class="table w-full table-zebra">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th class="w-24">Cant.</th>
                            <th>Notas</th>
                            <th class="text-right">Precio U.</th>
                            <th class="text-right">Subtotal</th>
                            <th class="w-10"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($this->budgetProducts as $product)
                            <tr wire:key="prod-{{ $product->id }}">
                                <td>{{ $product->name }}</td>
                                <td>
                                    <input type="number" value="{{ $product->pivot->quantity }}"
                                        wire:change="updateQuantity({{ $product->id }}, $event.target.value)"
                                        class="input input-bordered input-sm w-20" min="1" />
                                </td>
                                <td>
                                    <input type="text" value="{{ $product->pivot->notes }}"
                                        wire:change="updateNotes({{ $product->id }}, $event.target.value)"
                                        class="input input-bordered input-sm w-full" />
                                </td>
                                <td class="text-right">$ {{ number_format($product->pivot->price, 2) }}</td>
                                <td class="text-right font-bold">$
                                    {{ number_format($product->pivot->quantity * $product->pivot->price, 2) }}</td>
                                <td>
                                    <x-button icon="o-trash" wire:click="removeProduct({{ $product->id }})"
                                        class="btn-ghost btn-sm text-error" spinner />
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center italic opacity-50 py-4">Sin productos agregados aún.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-card>
    @endif
</div>