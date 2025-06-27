<?php

use Livewire\Volt\Component;
use App\Models\Budget;

new class extends Component {
    public $name = '';
    public $data = [
        'id' => null,
        'category_id' => '',
        'title' => '',
        'notes' => '',
        'total' => 0,
        'client_id' => null,
        'admin_id' => null,
    ];
    public $categories = [];
    public $eventtypes = [];

    public function mount($budget = null)
    {
        //chequear que el user sea admin
        if (auth()->user()->role != 'admin') {
            return redirect('/');
        }
        //buscar el presupuesto (como array) sino colocar variable iniciales en data
        $this->data = Budget::find($budget);

        if ($this->data == null) {
            $this->data = [
                'id' => null,
                'admin_id' => null,
                'client_id' => null,
                'title' => '',
                'category_id' => '',
                'notes' => '',
                'total' => 0,
                'status' => 'draft',
            ];
        } else {
            $this->data = $this->data->toArray();
        }

        $this->categories = \App\Models\Category::select('id', 'name')->get();
        $this->eventtypes = \App\Models\EventType::select('id', 'name')->get();
    }

    public function updateOrCreate()
    {
        dd($this->data);
        $result = Budget::updateOrCreate(
            ['id' => $this->data['id'] ? $this->data['id'] : null], // Si hay ID, actualiza; si no, crea
            $this->data, // Guarda todos los datos, incluida la ruta de la imagen
        );
        $this->success('Guardado con éxito!', redirectTo: '/budgets');
    }
}; ?>

<div>
    <x-card title="Presupuestos" shadow separator class="col-span-full">

        <x-form wire:submit="updateOrCreate">
            <x-input label="Nombre del Presupuesto" wire:model="data.title" />
            <x-select label="Categoria" wire:model="data.category_id" :options="$eventtypes" icon="o-tag" />
            <x-input label="Total" wire:model="data.total" prefix="$" money readonly/>
            <x-textarea label="Notas" wire:model="data.notes" placeholder="Sólo el texto necesario ..." rows="5" />

            <x-slot:actions>
                <x-button label="Cancel" />
                <x-button label="Click me!" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-form>
        

    </x-card>
</div>
