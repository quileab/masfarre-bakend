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
        // 1. Prepare data (Group items by category)
        $items = $budget->products()
            ->with('category')
            ->withPivot('quantity', 'price', 'notes')
            ->get()
            ->groupBy('category.name');

        $data = [
            'budget' => $budget,
            'client' => $budget->client,
            'items' => $items,
        ];

        // 2. Generate PDF
        $pdf = Pdf::loadView('pdf.budget', $data);

        // 3. Format Filename: [NroOrden]_[Apellido].pdf
        $id = str_pad($budget->id, 8, '0', STR_PAD_LEFT);
        $lastName = $budget->client ? Str::slug($budget->client->name) : 'cliente';
        if (empty($lastName)) $lastName = 'cliente';

        $filename = "{$id}_{$lastName}.pdf";
        
        // 4. Save to dedicated folder
        $path = "budgets/{$filename}";
        
        Storage::disk('public')->put($path, $pdf->output());

        return $path;
    }
}
