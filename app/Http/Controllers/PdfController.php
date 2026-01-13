<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PdfController extends Controller
{
    public static function generateBudgetPdf(Budget $budget)
    {
        $items = [];
        $total = 0;

        foreach ($budget->products as $product) {
            $quantity = $product->pivot->quantity;
            $price = $product->pivot->price;
            $subtotal = $quantity * $price;

            $items[$product->category->name ?? 'Sin Categoría'][] = [
                'name' => $product->name,
                'quantity' => $quantity,
                'price' => $price,
                'notes' => $product->pivot->notes,
                'subtotal' => $subtotal,
            ];

            $total += $subtotal;
        }

        $budget->update(['total' => $total]);

        $client = $budget->client;

        $pdf = PDF::loadView('pdf.budget', compact('budget', 'client', 'items', 'total'));

        $id = str_pad($budget->id, 8, '0', STR_PAD_LEFT);
        $lastName = $client ? Str::slug($client->name) : 'cliente';
        if (empty($lastName)) $lastName = 'cliente';

        $filename = "{$id}_{$lastName}.pdf";
        $path = "budgets/{$filename}";
        Storage::disk('public')->put($path, $pdf->output());

        return $path;
    }

    public static function generatePaymentsPdf(Budget $budget)
    {
        // Calculate budget totals
        $budgetTotal = $budget->products->sum(function ($product) {
            return $product->pivot->price * $product->pivot->quantity;
        });

        // Get all transactions ordered by date
        $transactions = $budget->transactions()
            ->orderBy('transaction_date', 'asc')
            ->get();

        // Calculate running balance
        $balance = $budgetTotal;
        $totalCharges = 0;
        $totalPayments = 0;

        $paymentsData = [];
        foreach ($transactions as $transaction) {
            if ($transaction->type === 'charge') {
                $balance += $transaction->amount;
                $totalCharges += $transaction->amount;
                $debe = number_format($transaction->amount, 2, ",", ".");
                $haber = '';
            } else { // payment
                $balance -= $transaction->amount;
                $totalPayments += $transaction->amount;
                $debe = '';
                $haber = number_format($transaction->amount, 2, ",", ".");
            }

            $paymentsData[] = [
                'date' => $transaction->transaction_date->format('d/m/Y'),
                'concept' => $transaction->description,
                'debe' => $debe,
                'haber' => $haber,
                'balance' => number_format($balance, 2, ",", "."),
            ];
        }

        $client = $budget->client;

        $totals = [
            'initial_budget' => number_format($budgetTotal, 2, ",", "."),
            'total_charges' => number_format($totalCharges, 2, ",", "."),
            'total_payments' => number_format($totalPayments, 2, ",", "."),
            'final_balance' => number_format($balance, 2, ",", "."),
        ];

        $pdf = PDF::loadView('pdf.payments', compact('budget', 'client', 'paymentsData', 'totals'));

        $id = str_pad($budget->id, 8, '0', STR_PAD_LEFT);
        $lastName = $client ? Str::slug($client->name) : 'cliente';
        if (empty($lastName)) $lastName = 'cliente';

        $filename = "pagos_{$id}_{$lastName}.pdf";
        $path = "budgets/payments/{$filename}";
        Storage::disk('public')->put($path, $pdf->output());

        return $path;
    }
}
