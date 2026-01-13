<?php

use Livewire\Volt\Component;
use App\Models\Budget;
use App\Models\BudgetTransaction;
use Illuminate\Support\Facades\Auth;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

new class extends Component {
    use AuthorizesRequests;

    public Budget $budget;

    // Form properties
    public $amount;
    public $description;
    public $type = 'payment'; // default
    public $date;

    public function mount(Budget $budget)
    {
        $this->budget = $budget;
        $this->date = now()->format('Y-m-d');

        // Ensure only admins can access payment management
        $user = auth()->user();
        if (!$user || $user->role !== 'admin') {
            abort(403, 'No tienes permisos para acceder a esta página.');
        }
    }

    public function saveTransaction()
    {
        $this->authorize('manageTransactions', $this->budget);

        $this->validate([
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required|string|max:255',
            'type' => 'required|in:payment,charge',
            'date' => 'required|date',
        ]);

        $transaction = $this->budget->transactions()->create([
            'user_id' => Auth::id(),
            'amount' => $this->amount,
            'description' => $this->description,
            'type' => $this->type,
            'transaction_date' => $this->date,
        ]);

        // Generate Receipt PDF
        try {
            $path = \App\Http\Controllers\PdfController::generateTransactionReceiptPdf($transaction);
            $this->dispatch('pdf-generated', path: asset('storage/' . $path));
        } catch (\Exception $e) {
            $this->error('Movimiento guardado, pero error al generar recibo: ' . $e->getMessage());
        }

        $this->reset(['amount', 'description', 'type']);
        $this->date = now()->format('Y-m-d');

        $this->dispatch('transaction-saved');
    }

    public function deleteTransaction($id)
    {
        $this->authorize('manageTransactions', $this->budget);

        $transaction = $this->budget->transactions()->findOrFail($id);
        $transaction->delete();
    }

    public function generatePaymentsPdf()
    {
        $this->authorize('manageTransactions', $this->budget);

        try {
            $path = \App\Http\Controllers\PdfController::generatePaymentsPdf($this->budget);
            $this->dispatch('pdf-generated', path: asset('storage/' . $path));
        } catch (\Exception $e) {
            $this->error('Error generando el PDF: ' . $e->getMessage());
        }
    }

    public function with()
    {
        $budgetTotal = $this->budget->products->sum(function ($product) {
            return $product->pivot->price * $product->pivot->quantity;
        });

        // Load transactions once
        $transactions = $this->budget->transactions()
            ->orderBy('transaction_date', 'desc')
            ->get();

        $charges = $transactions->where('type', 'charge')->sum('amount');
        $payments = $transactions->where('type', 'payment')->sum('amount');

        $total = $budgetTotal + $charges;
        $balance = $total - $payments;

        return [
            'transactions' => $transactions,
            'budgetTotal' => $budgetTotal,
            'totalCharges' => $charges,
            'totalPayments' => $payments,
            'finalTotal' => $total,
            'balance' => $balance,
        ];
    }
}; ?>

    <div class="p-6 bg-base-100 rounded-xl shadow-sm border border-base-200">
     <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
         <div>
             <h2 class="text-2xl font-bold">Cuenta Corriente</h2>
             <p class="text-base-content/70">Gestiona pagos y adicionales del presupuesto</p>
         </div>

         <div class="flex gap-2">
             @php $user = auth()->user() @endphp
             @if($user && $user->role === 'admin')
                 <button onclick="transaction_modal.showModal()" class="btn btn-primary">
                     <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                     </svg>
                     Registrar Movimiento
                 </button>
                 <button wire:click="generatePaymentsPdf" class="btn btn-outline btn-info">
                     <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                     </svg>
                     Generar PDF
                 </button>
             @endif
         </div>
     </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="stats shadow bg-base-300">
            <div class="stat">
                <div class="stat-title">Presupuesto Inicial</div>
                <div class="stat-value text-primary text-2xl">${{ number_format($budgetTotal, 2, ",", ".") }}</div>
            </div>
        </div>

        <div class="stats shadow bg-base-300">
            <div class="stat">
                <div class="stat-title">Adicionales</div>
                <div class="stat-value text-warning text-2xl">+ ${{ number_format($totalCharges, 2, ",", ".") }}</div>
            </div>
        </div>

        <div class="stats shadow bg-base-300">
            <div class="stat">
                <div class="stat-title">Pagado</div>
                <div class="stat-value text-success text-2xl">- ${{ number_format($totalPayments, 2, ",", ".") }}</div>
            </div>
        </div>

        <div class="stats shadow {{ $balance > 0 ? 'bg-error/10' : 'bg-success/10' }}">
            <div class="stat">
                <div class="stat-title font-bold">Saldo Pendiente</div>
                <div class="stat-value {{ $balance > 0 ? 'text-error' : 'text-success' }} text-3xl">
                    ${{ number_format($balance, 2, ",", ".") }}
                </div>
            </div>
        </div>
    </div>

    <!-- Transactions Table -->
    <div class="overflow-x-auto">
        <table class="table table-zebra w-full">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Descripción</th>
                    <th>Tipo</th>
                    <th class="text-right">Monto</th>
                    @php $user = auth()->user() @endphp
                    @if($user && $user->role === 'admin')
                        <th class="text-right">Acciones</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->transaction_date->format('d/m/Y') }}</td>
                        <td>{{ $transaction->description }}</td>
                        <td>
                            @if($transaction->type === 'payment')
                                <span class="badge badge-success gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        class="inline-block w-4 h-4 stroke-current">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Pago
                                </span>
                            @else
                                <span class="badge badge-warning gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        class="inline-block w-4 h-4 stroke-current">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                        </path>
                                    </svg>
                                    Adicional
                                </span>
                            @endif
                        </td>
                        <td
                            class="text-right font-mono font-bold {{ $transaction->type === 'payment' ? 'text-success' : 'text-warning' }}">
                            {{ $transaction->type === 'payment' ? '-' : '+' }} ${{ number_format($transaction->amount, 2, ",", ".") }}
                        </td>
                        @php $user = auth()->user() @endphp
                        @if($user && $user->role === 'admin')
                            <td class="text-right">
                                <button wire:click="deleteTransaction({{ $transaction->id }})"
                                    wire:confirm="¿Estás seguro de eliminar este movimiento?"
                                    class="btn btn-ghost btn-xs text-error">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-8 text-base-content/50">
                            No hay movimientos registrados
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <dialog id="transaction_modal" class="modal" wire:ignore.self>
        <div class="modal-box">
            <h3 class="font-bold text-lg mb-4">Registrar Movimiento</h3>

            <form wire:submit="saveTransaction">
                <div class="form-control w-full mb-3">
                    <label class="label"><span class="label-text">Tipo</span></label>
                    <select wire:model="type" class="select select-bordered w-full">
                        <option value="payment">Pago / Abono</option>
                        <option value="charge">Cargo Adicional</option>
                    </select>
                </div>

                <div class="form-control w-full mb-3">
                    <label class="label"><span class="label-text">Fecha</span></label>
                    <input type="date" wire:model="date" class="input input-bordered w-full" />
                </div>

                <div class="form-control w-full mb-3">
                    <label class="label"><span class="label-text">Monto</span></label>
                    <label class="input-group">
                        <span>$</span>
                        <input type="number" step="0.01" wire:model="amount" class="input input-bordered w-full"
                            placeholder="0.00" />
                    </label>
                </div>

                <div class="form-control w-full mb-6">
                    <label class="label"><span class="label-text">Descripción</span></label>
                    <input type="text" wire:model="description" class="input input-bordered w-full"
                        placeholder="Ej. Pago de seña" />
                </div>

                <div class="modal-action">
                    <button type="button" class="btn" onclick="transaction_modal.close()">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>

    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('transaction-saved', () => {
                transaction_modal.close();
            });

            @this.on('pdf-generated', (event) => {
                const link = document.createElement('a');
                link.href = event.path;
                link.download = 'reporte-pagos.pdf';
                link.target = '_blank';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            });
        });
    </script>
</div>