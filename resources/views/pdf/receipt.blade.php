<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recibo de Pago</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 14px;
            margin: 0;
            padding: 20px;
        }
        .container {
            width: 100%;
        }
        .receipt-box {
            position: relative; /* Contexto de posicionamiento para watermark */
            border: 1px solid #333;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .header {
            width: 100%;
            margin-bottom: 20px;
        }
        .header td {
            vertical-align: top;
        }
        .company-info {
            text-align: right;
            font-size: 12px;
            color: #555;
            padding-top: 25px; /* Espacio para no solapar watermark */
        }
        .title {
            font-size: 24px;
            font-weight: bold;
            text-transform: uppercase;
            text-align: center;
            margin-bottom: 10px;
        }
        .label {
            font-weight: bold;
            display: inline-block;
            width: 100px;
        }
        .row {
            margin-bottom: 10px;
            border-bottom: 1px dotted #ccc;
            padding-bottom: 5px;
        }
        .amount-words {
            font-style: italic;
            color: #333;
        }
        .amount-box {
            text-align: right;
            font-size: 18px;
            font-weight: bold;
            background: #eee;
            padding: 10px;
            border-radius: 4px;
            margin-top: 10px;
        }
        .signature {
            margin-top: 40px;
            text-align: center;
        }
        .signature-line {
            border-top: 1px solid #000;
            width: 200px;
            display: inline-block;
            margin-top: 40px;
        }
        .cut-line {
            border-top: 2px dashed #999;
            margin: 40px 0;
            position: relative;
            text-align: center;
        }
        .cut-icon {
            background: #fff;
            padding: 0 10px;
            position: relative;
            top: -10px;
            color: #999;
            font-size: 12px;
        }
        .watermark {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 10px;
            color: #777;
            border: 1px solid #777;
            padding: 2px 6px;
            border-radius: 3px;
            text-transform: uppercase;
            background: #fff;
        }
    </style>
</head>
<body>

    @php
        $clientName = $transaction->budget->client ? $transaction->budget->client->name : 'Consumidor Final';
        $budgetId = str_pad($transaction->budget->id, 8, '0', STR_PAD_LEFT);
        $date = $transaction->transaction_date->format('d/m/Y');
        $amount = number_format($transaction->amount, 2, ',', '.');
        $type = $transaction->type === 'payment' ? 'PAGO' : 'CARGO';
    @endphp

    {{-- ORIGINAL --}}
    <div class="receipt-box">
        <div class="watermark">Original</div>
        <table class="header">
            <tr>
                <td width="30%">
                    <img src="{{ public_path('images/masfarre-serv_audiov.png') }}" style="width: 150px; height: auto;" alt="Logo">
                </td>
                <td width="40%" align="center">
                    <div class="title">RECIBO</div>
                    <div>Nº Movimiento: {{ str_pad($transaction->id, 6, '0', STR_PAD_LEFT) }}</div>
                </td>
                <td width="30%" class="company-info">
                    Fecha: <strong>{{ $date }}</strong><br>
                    Ref. Presupuesto: #{{ $budgetId }}
                </td>
            </tr>
        </table>

        <div class="row">
            <span class="label">Recibí de:</span> {{ $clientName }}
        </div>

        <div class="row">
            <span class="label">Son:</span> <span class="amount-words">{{ $amountInWords }} Pesos</span>
        </div>
        
        <div class="row">
            <span class="label">Concepto:</span> {{ $transaction->description }} ({{ $type }})
        </div>

        <table width="100%">
            <tr>
                <td valign="bottom">
                    <div class="signature">
                        <div class="signature-line"></div>
                        <div>Firma / Aclaración</div>
                    </div>
                </td>
                <td width="40%" align="right">
                    <div class="amount-box">
                       $ {{ $amount }}
                    </div>
                </td>
            </tr>
        </table>
    </div>

    {{-- LÍNEA DE CORTE --}}
    <div class="cut-line">
        <span class="cut-icon">✂ Corte aquí</span>
    </div>

    {{-- DUPLICADO --}}
    <div class="receipt-box">
        <div class="watermark">Duplicado</div>
        <table class="header">
            <tr>
                <td width="30%">
                    <img src="{{ public_path('images/masfarre-serv_audiov.png') }}" style="width: 150px; height: auto;" alt="Logo">
                </td>
                <td width="40%" align="center">
                    <div class="title">RECIBO</div>
                    <div>Nº Movimiento: {{ str_pad($transaction->id, 6, '0', STR_PAD_LEFT) }}</div>
                </td>
                <td width="30%" class="company-info">
                    Fecha: <strong>{{ $date }}</strong><br>
                    Ref. Presupuesto: #{{ $budgetId }}
                </td>
            </tr>
        </table>

        <div class="row">
            <span class="label">Recibí de:</span> {{ $clientName }}
        </div>

        <div class="row">
            <span class="label">Son:</span> <span class="amount-words">{{ $amountInWords }} Pesos</span>
        </div>
        
        <div class="row">
            <span class="label">Concepto:</span> {{ $transaction->description }} ({{ $type }})
        </div>

        <table width="100%">
            <tr>
                <td valign="bottom">
                    <div class="signature">
                        <div class="signature-line"></div>
                        <div>Firma / Aclaración</div>
                    </div>
                </td>
                <td width="40%" align="right">
                    <div class="amount-box">
                       $ {{ $amount }}
                    </div>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>