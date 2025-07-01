<?php

namespace App\Livewire\Budget;

use App\Models\Budget;
use Livewire\Component;

class UserShow extends Component
{
    public Budget $budget;

    public function mount(Budget $budget)
    {
        $this->budget = $budget->load('products', 'client', 'category');
    }

    public function render()
    {
        return view('livewire.budget.user-show');
    }
}