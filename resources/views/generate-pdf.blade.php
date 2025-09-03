<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Relatório de Venda</title>
</head>
<body>
    <h2>Relatório de Vendas</h2>
    <p>Relatório gerado em: {{ date('d/m/Y') }}</p>
    <p>Total de vendas: {{ count($sales) }}</p>
    <p>Cliente: {{ $filters['name'] }} - Até R$ {{ $filters['total'] }} reais</p>
    <table width="100%" border="1" cellspacing="0" cellpadding="5">
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Produto</th>
                <th>Quantidade</th>
                <th>Total</th>
                <th>Data</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $sale)
                <tr>
                    <td>{{ $sale->user->name }}</td>
                    <td>{{ $sale->product->name }}</td>
                    <td>{{ $sale->quantity }}</td>
                    <td>R$ {{ number_format($sale->total, 2, ',', '.') }}</td>
                    <td>{{ $sale->created_at->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>