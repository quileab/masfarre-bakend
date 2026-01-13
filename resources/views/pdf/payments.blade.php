<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Reporte de Pagos - Presupuesto #{{ str_pad($budget->id, 8, '0', STR_PAD_LEFT) }}</title>
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
            font-size: 24px;
        }

        .details {
            width: 100%;
            margin-bottom: 20px;
        }

        .details td {
            vertical-align: top;
        }

        .payments-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .payments-table th,
        .payments-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 12px;
        }

        .payments-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .text-right {
            text-align: right !important;
        }

        .text-center {
            text-align: center !important;
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
                    <h1>Reporte de Pagos</h1>
                    <p>
                        <strong>Presupuesto:</strong> #{{ str_pad($budget->id, 8, '0', STR_PAD_LEFT) }}
                        <br>
                        <strong>Cliente:</strong> {{ $client->name ?? 'N/A' }}
                        <br>
                        <strong>Fecha:</strong> {{ now()->format('d/m/Y') }}
                    </p>
                </td>
            </tr>
        </table>
    </div>

    <table class="payments-table">
        <thead>
            <tr>
                <th class="text-center" style="width: 100px;">Fecha</th>
                <th>Concepto</th>
                <th class="text-right" style="width: 100px;">Debe</th>
                <th class="text-right" style="width: 100px;">Haber</th>
                <th class="text-right" style="width: 100px;">Saldo</th>
            </tr>
        </thead>
        <tbody>
            <!-- Primera línea: Presupuesto inicial -->
            <tr style="background-color: #f9f9f9;">
                <td class="text-center">{{ $budget->date ? $budget->date->format('d/m/Y') : 'N/A' }}</td>
                <td>{{ $budget->name }}</td>
                <td class="text-right">${{ $totals['initial_budget'] }}</td>
                <td class="text-right">-</td>
                <td class="text-right">${{ $totals['initial_budget'] }}</td>
            </tr>

            <!-- Movimientos registrados -->
            @if(count($paymentsData) > 0)
                @foreach($paymentsData as $payment)
                <tr>
                    <td class="text-center">{{ $payment['date'] }}</td>
                    <td>{{ $payment['concept'] }}</td>
                    <td class="text-right">{{ $payment['debe'] ?: '-' }}</td>
                    <td class="text-right">{{ $payment['haber'] ?: '-' }}</td>
                    <td class="text-right">${{ $payment['balance'] }}</td>
                </tr>
                @endforeach
            @endif
        </tbody>
        <tfoot>
            <!-- Línea de TOTALES -->
            <tr style="background-color: #e0e0e0; border-top: 2px solid #333;">
                <td class="text-center" style="font-weight: bold;">{{ now()->format('d/m/Y') }}</td>
                <td style="font-weight: bold;">TOTALES</td>
                <td class="text-right" style="font-weight: bold;">${{ $totals['total_charges'] }}</td>
                <td class="text-right" style="font-weight: bold;">${{ $totals['total_payments'] }}</td>
                <td class="text-right" style="font-weight: bold;">${{ $totals['final_balance'] }}</td>
            </tr>
        </tfoot>
    </table>

</body>

</html>