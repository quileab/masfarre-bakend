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
    public function mount($budget = null)
    {
        //chequear que el user sea admin
        if (auth()->user()->role != 'admin') {
            return redirect('/');
        }
        //buscar el presupuesto sino colocar variable iniciales en data
        $this->data=Budget::find($budget);
        if ($this->data==null) {
            $this->data = [
                'id' => null,
                'category_id' => '',
                'title' => '',
                'notes' => '',
                'total' => 0,
                'client_id' => null,
                'admin_id' => auth()->user()->id,
            ];
        }
        else{
            $this->data->toArray();
        }

        dd($this->data);

    }
}; ?>

<div>
    {{ $name }}
</div>
