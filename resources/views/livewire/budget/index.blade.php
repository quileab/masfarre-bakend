<?php

use Livewire\Volt\Component;
use App\Models\Budget;
use App\Http\Controllers\PdfController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Url;

new class extends Component {

    #[Url]
    public $client_id = '';

    public string $search = '';
    public int $records_count = 0;
    public bool $drawer = false;
    public array $sortBy = ['column' => 'id', 'direction' => 'asc'];

    public function delete(Budget $budgetId)
    {
        $budgetId->delete();
        //$this->budgets = Budget::all();
    }

    public function share(Budget $budget)
    {
        $id = str_pad($budget->id, 8, '0', STR_PAD_LEFT);
        $lastName = $budget->client ? Str::slug($budget->client->name) : 'cliente';
        if (empty($lastName)) $lastName = 'cliente';

        $filename = "{$id}_{$lastName}.pdf";
        $path = "budgets/{$filename}";

        if (Storage::disk('public')->exists($path)) {
            $link = asset('storage/' . $path);
            $this->dispatch('copy-link', link: $link);
        } else {
            $this->error('El PDF no existe.');
        }
    }

    // Table headers
    public function headers(): array
    {
        return [
            ['key' => 'id', 'label' => '#', 'class' => 'w-1'],
            ['key' => 'name', 'label' => 'Presupuesto'],
            ['key' => 'client.name', 'label' => 'Cliente', 'sortable' => false],
            ['key' => 'total', 'label' => 'Monto'],
            ['key' => 'status', 'label' => 'Estado'],
            ['key' => 'payments', 'label' => 'Pagos', 'sortable' => false],
        ];
    }

    public function budgets()
    {
        if (auth()->user() && auth()->user()->role !== 'admin') {
            $clientId = session('user')['id'] ?? null;
            if ($clientId) {
                return Budget::where('client_id', $clientId)->with('client')->paginate(15);
            } else {
                return Budget::whereNull('client_id')->with('client')->paginate(15); // Or handle as appropriate if no client is selected
            }
        }
        $result = Budget::with('client', 'transactions')//query()
            ->when($this->search, fn($q) => $q->where('name', 'like', "%$this->search%")) // Updated 'name' to 'title'
            ->when($this->client_id, fn($q) => $q->where('client_id', $this->client_id))
            ->orderBy(...array_values($this->sortBy))
            ->paginate(15);

        $this->records_count = $result->total();
        return $result;
    }

    public function with(): array
    {
        return [
            'budgets' => $this->budgets(),
            'headers' => $this->headers(),
        ];
    }

}; ?>

<div>
    <!-- HEADER -->
    <x-header title="Presupuestos" separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <x-input placeholder="Buscar..." wire:model.live.debounce="search" clearable icon="o-magnifying-glass" />
        </x-slot:middle>
        <x-slot:actions>
            <x-badge value="{{ $records_count }}" class="badge-primary" />
            @if(auth()->user() && auth()->user()->role === 'admin')
                <x-button label="Nuevo" icon="o-check" class="btn-primary" link="/budget" />
            @endif
        </x-slot:actions>
    </x-header>

    <!-- TABLE  -->
    <x-card>
        <x-table :headers="$headers" :rows="$budgets" :sort-by="$sortBy"
            link="{{ auth()->user() && auth()->user()->role === 'admin' ? 'budget/{id}' : 'budgets/{id}/view' }}" striped>
            @scope('cell_total', $budget)
            <p class="text-right w-full text-warning">$&nbsp;{{ number_format($budget->total, 2, ",", ".") }}</p>
            @endscope
            @scope('cell_status', $budget)
                @if($budget->status === 'approved')
                    <span class="badge badge-success">Aprobado</span>
                @elseif($budget->status === 'sent')
                    <span class="badge badge-warning">Enviado</span>
                @elseif($budget->status === 'draft')
                    <span class="badge badge-info">Borrador</span>
                @elseif($budget->status === 'rejected')
                    <span class="badge badge-error">Rechazado</span>
                @else
                    <span class="badge badge-neutral">{{ $budget->status }}</span>
                @endif
            @endscope
            @scope('cell_payments', $budget)
                @php
                    $budgetTotal = $budget->products->sum(function ($product) {
                        return $product->pivot->price * $product->pivot->quantity;
                    });
                    $totalCharges = $budget->transactions->where('type', 'charge')->sum('amount');
                    $totalPayments = $budget->transactions->where('type', 'payment')->sum('amount');
                    $finalTotal = $budgetTotal + $totalCharges;
                    $balance = $finalTotal - $totalPayments;
                @endphp

                @if($budget->status === 'approved')
                    <div class="flex flex-col items-end gap-1">
                        <div class="text-xs text-gray-500">
                            Pagado: ${{ number_format($totalPayments, 2, ",", ".") }}
                        </div>
                        @if($balance > 0)
                            <div class="text-xs text-error font-semibold">
                                Pendiente: ${{ number_format($balance, 2, ",", ".") }}
                            </div>
                        @else
                            <div class="text-xs text-success font-semibold">
                                Saldado
                            </div>
                        @endif
                    </div>
                @else
                    <span class="text-xs text-gray-400 italic">Pendiente aprobación</span>
                @endif
            @endscope

             @scope('actions', $budget)
                  @php
                      $id = str_pad($budget->id, 8, '0', STR_PAD_LEFT);
                      $lastName = $budget->client ? \Illuminate\Support\Str::slug($budget->client->name) : 'cliente';
                      if (empty($lastName)) $lastName = 'cliente';
                      $filename = "{$id}_{$lastName}.pdf";
                      $path = "budgets/{$filename}";
                      $exists = \Illuminate\Support\Facades\Storage::disk('public')->exists($path);
                  @endphp
                  <div class="flex gap-1 items-center">
                     <button wire:click="{{ $exists ? 'share(' . $budget['id'] . ')' : '' }}"
                             class="btn btn-sm {{ $exists ? 'btn-ghost text-primary' : 'btn-ghost text-error' }}"
                             title="{{ $exists ? 'Copiar enlace público' : 'PDF no generado' }}">
                         <x-icon name="{{ $exists ? 'o-share' : 'o-link-slash' }}" class="w-6 h-6" />
                     </button>
                     @if($exists)
                         <a href="{{ asset('storage/' . $path) }}" target="_blank" class="btn btn-sm btn-ghost text-success" title="Ver PDF">
                             <x-icon name="o-link" class="w-6 h-6" />
                         </a>
                     @endif
                     @if($budget->status === 'approved' && auth()->check() && auth()->user()->role === 'admin')
                         <a href="/budget/{{ $budget->id }}/payments" class="btn btn-sm btn-ghost text-info" title="Gestionar Pagos">
                             <x-icon name="o-currency-dollar" class="w-6 h-6" />
                         </a>
                     @endif
                  </div>
              @endscope
        </x-table>
    </x-card>

    <script>
        document.addEventListener('livewire:initialized', () => {
            const showSuccessToast = (message) => {
                window.dispatchEvent(new CustomEvent('mary-toast', {
                    detail: {
                        toast: {
                            title: "Copiado",
                            description: message,
                            type: "success",
                            position: "toast-bottom toast-end",
                            timeout: 3000,
                            icon: "o-check",
                            css: "alert-success"
                        }
                    }
                }));
            };

            Livewire.on('copy-link', (event) => {
                let link = event.link;
                if (!link && event[0] && event[0].link) link = event[0].link;

                if (!link) return;

                if (navigator.clipboard && window.isSecureContext) {
                    navigator.clipboard.writeText(link).then(() => {
                        showSuccessToast('Enlace copiado al portapapeles');
                    }).catch(err => {
                        console.error('Async: Could not copy text: ', err);
                    });
                } else {
                    let textArea = document.createElement("textarea");
                    textArea.value = link;
                    textArea.style.position = "fixed";
                    textArea.style.left = "-9999px";
                    textArea.style.top = "0";
                    document.body.appendChild(textArea);
                    textArea.focus();
                    textArea.select();
                    try {
                        document.execCommand('copy');
                        showSuccessToast('Enlace copiado al portapapeles');
                    } catch (err) {
                        console.error('Fallback: Oops, unable to copy', err);
                    }
                    document.body.removeChild(textArea);
                }
            });
        });
    </script>
</div>