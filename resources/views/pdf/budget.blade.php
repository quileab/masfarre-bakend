<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Presupuesto #{{ str_pad($budget->id, 8, '0', STR_PAD_LEFT) }}</title>
    <style>
        body {
            font-family: sans-serif;
        }
        pre {
            font-family: sans-serif;
        }

        .header {
            margin-bottom: 20px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
        }

        .header h1 {
            margin: 0;
        }

        .details {
            width: 100%;
            margin-bottom: 20px;
        }

        .details td {
            vertical-align: top;
        }

        .items {
            width: 100%;
            border-collapse: collapse;
        }

        .items th,
        .items td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 12px;
        }

        .items th {
            background-color: #f2f2f2;
        }

        .text-right {
            text-align: right !important;
        }

        .currency {
            white-space: nowrap;
        }

        .category-header {
            background-color: #e0e0e0;
            font-weight: bold;
        }

        .total-section {
            margin-top: 10px;
            text-align: right;
            font-size: 16px;
            font-weight: bold;
            padding-top: 10px;
        }
    </style>
</head>

<body>

    <div class="header">
        <table width="100%">
            <tr>
                <td valign="top">
                    <img src="{{ public_path('images/masfarre-serv_audiov.png') }}" style="width: 250px; height: auto;"
                        alt="Masfarre">
                </td>
                <td valign="top" align="right">
                    <h1>Presupuesto</h1>
                    <p>
                        <strong>Número:</strong> {{ str_pad($budget->id, 8, '0', STR_PAD_LEFT) }}
                        <br>
                        <strong>Fecha del Evento:</strong> {{ $budget->date ? $budget->date->format('d/m/Y') : 'N/A' }}
                    </p>
                </td>
            </tr>
        </table>
    </div>

    <table class="details">
        <tr>
            <td>
                <strong>Cliente:</strong><br>
                {{ $client->name ?? 'N/A' }}<br>
                {{ $client->email ?? '' }}<br>
                {{ $client->phone ?? '' }}
            </td>
            <td class="text-right">
                <strong>Detalles:</strong><br>
                {{ $budget->name }}<br>
                Tipo: {{ $budget->eventType->name ?? 'N/A' }}
            </td>
        </tr>
    </table>

    <table class="items">
        <thead>
            <tr>
                <th width="30%">Concepto</th>
                <th class="text-right" width="10%">Cant.</th>
                <th class="text-right" width="15%">Precio U.</th>
                <th width="30%">Notas</th>
                <th class="text-right" width="15%">Monto Final</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $category => $products)
                <tr class="category-header">
                    <td colspan="5">{{ $category }}</td>
                </tr>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td class="text-right">{{ $product->pivot->quantity }}</td>
                        <td class="text-right currency">$ {{ number_format($product->pivot->price, 2, ",", ".") }}</td>
                        <td>{{ $product->pivot->notes }}</td>
                        <td class="text-right currency">$
                            {{ number_format($product->pivot->quantity * $product->pivot->price, 2, ",", ".") }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

    <div class="total-section">
        Total: <span class="currency">$ {{ number_format($budget->total, 2, ",", ".") }}</span>
    </div>

    @if($budget->notes)
        <div style="margin-top: 30px; font-size: 12px; color: #555;">
            <strong>Notas:</strong>
            <pre>{!! $budget->notes !!}</pre>
        </div>
    @endif

</body>

</html>