<?php

use Livewire\Volt\Component;
use App\Models\Budget;
use Mary\Traits\Toast;

new class extends Component {
    use Toast;

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

    public function mount(Budget $budget)
    {
        if (\App\Models\User::getSessionUser() == null) {
            return redirect('/users');
        }
        //chequear que el user sea admin
        if (auth()->user()->role != 'admin') {
            return redirect('/');
        }

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
            $this->data = $budget->toArray();
            $this->client = $budget->client;
        }

        $this->eventtypes = \App\Models\EventType::select('id', 'name')->get();
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
            ['id' => $validated['data']['id']], // Si hay ID, actualiza; si no, crea
            $validated['data']
        );
        // if result ok then mount the component with the new data
        $this->mount($result);
        $this->success('Guardado con éxito!');
    }
}; ?>

<div>
    <x-card title="Presupuesto: {{ $this->client['name'] }}" shadow separator class="col-span-full">
        @if ($this->data['id'])
            <x-slot:menu>
                <x-button label="Detalle" icon="o-document-currency-dollar" class="btn-primary"
                    link="/budgets/{{ $this->data['id'] }}" />
            </x-slot:menu>
        @endif
        <x-form wire:submit="updateOrCreate">
            <x-input label="Nombre del Presupuesto" wire:model="data.name" />
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-select label="Tipo de Evento" wire:model="data.event_type_id" :options="$eventtypes" icon="o-tag" />
                <x-input label="Fecha" wire:model="data.date" type="date" />
                <x-select label="Estado" wire:model="data.status" :options="$statuses" option-label="label"
                    option-value="name" />
                <x-input label="Total" wire:model="data.total" prefix="$" money readonly />
            </div>
            <x-textarea label="Notas" wire:model="data.notes" placeholder="Sólo el texto necesario ..." rows="5" />

            <x-slot:actions>
                <x-button label="Volver" icon="o-x-mark" class="btn-secondary" link="/budgets" />
                <x-button label="Guardar" icon="o-check" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-form>
    </x-card>
</div>