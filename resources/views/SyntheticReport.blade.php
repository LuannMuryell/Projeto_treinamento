<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Imóveis</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }
        th, td {
            border: 1px solid black;
            padding: 5px;
            text-align: center;
        }
        tbody tr:nth-child(odd) {
            background-color: #f2f2f2;
        }
        body {
            font-size: 14px;
        }
        h2 {
            text-align: center;
            font-size: 18px;
            margin-bottom: 4px;
        }
        h3 {
            font-size: 17px;
            margin-top: 4px;
        }
        h4 {
            font-size: 15px;
            margin-bottom: 5px;
        }
        img {
            width: 60px; 
        }
        div {
            text-align: center
        }
    </style>
</head>
<body>
<header>
    <div>
        <img src="img/brasao.png" alt="Brasão">
        <h2>PREFEITURA MUNICIPAL DE SÃO LEOPOLDO</h2>
        <h3>Estado do Rio Grande do Sul</h3>
        <h4>RELATÓRIO DE IMÓVEIS</h4>
    </div>
</header>
    <main>
        <table>
            <thead>
                <tr>
                    <th>Inscrição Municipal</th>
                    <th>Contribuinte</th>
                    <th>Tipo</th>
                    <th>Logradouro</th>
                    <th>Número</th>
                    <th>Bairro</th>
                    <th>Área do Terreno</th>
                    <th>Área da Edificação</th>
                    <th>Situação</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($properties as $property)
                    <tr>
                        <td>{{ $property->ins_municipal }}</td>
                        <td>{{ $property->contribuinte->name }}</td>
                        <td>{{ $property->tipo }}</td>
                        <td>{{ $property->logradouro }}</td>
                        <td>{{ $property->numero }}</td>
                        <td>{{ $property->bairro }}</td>
                        <td>{{ $property->area_terreno }}m²</td>
                        <td>{{ $property->area_edificacao }}m²</td>
                        <td>{{ $property->situacao }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </main>
</body>
</html>
