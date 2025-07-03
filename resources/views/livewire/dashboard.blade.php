<?php

use Livewire\Volt\Component;
use Carbon\Carbon;
use App\Models\Budget;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;

new class extends Component {
    public Carbon $currentDate;

    public function mount(): void
    {
        $this->currentDate = Carbon::now();
    }

    public function previousMonth(): void
    {
        $this->currentDate->subMonth();
    }

    public function nextMonth(): void
    {
        $this->currentDate->addMonth();
    }

    #[Computed]
    public function events(): Collection
    {
        return Budget::query()
            ->whereMonth('date', $this->currentDate->month)
            ->whereYear('date', $this->currentDate->year)
            ->orderBy('date')
            ->get()
            ->groupBy(fn($budget) => Carbon::parse($budget->date)->format('j'));
    }

    public function getDaysInMonthProperty(): Collection
    {
        $startOfMonth = $this->currentDate->copy()->startOfMonth();
        $endOfMonth = $this->currentDate->copy()->endOfMonth();
        $days = collect();

        for ($date = $startOfMonth; $date->lte($endOfMonth); $date->addDay()) {
            $days->push($date->copy());
        }

        return $days;
    }

    public function getBlankDaysProperty(): int
    {
        return $this->currentDate->copy()->startOfMonth()->dayOfWeekIso % 7;
    }
}; ?>

<div>
    <x-header :title="'Calendario de Eventos'" separator>
        <x-slot:actions>
            <x-button icon="o-chevron-left" wire:click="previousMonth" spinner />
            <x-button icon="o-chevron-right" wire:click="nextMonth" spinner />
        </x-slot:actions>
    </x-header>

    <div class="text-center text-2xl font-bold mb-4">
        {{ $currentDate->translatedFormat('F Y') }}
    </div>

    <div class="grid grid-cols-7 gap-1">
        @foreach(['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'] as $day)
            <div class="text-center font-bold text-gray-500 p-2">{{ $day }}</div>
        @endforeach

        @for ($i = 0; $i < $this->blankDays; $i++)
            <div></div>
        @endfor

        @foreach ($this->daysInMonth as $day)
            <div class="border rounded-lg p-2 h-32 flex flex-col {{ $day->isToday() ? 'bg-blue-50/50' : '' }}">
                <div class="font-bold text-right">{{ $day->day }}</div>
                <div class="flex-grow overflow-y-auto">
                    @if(isset($this->events[$day->day]))
                        @foreach($this->events[$day->day] as $event)
                            <x-button :label="$event->name" class="btn-primary btn-xs" link="budget/{{ $event->id }}"
                                title="{{ $event->client->name }}" />
                            {{-- <x-badge :value="$event->name" class="badge-primary text-white truncate" /> --}}
                        @endforeach
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>