<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartSol | Rapport des Données d'Énergie</title>
        <link rel="shortcut icon" href="{{ asset('images/logo1.png') }}" type="image/x-icon">

    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            margin: 30px;
            color: #333;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color:#FBB108;

        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 12px;
            text-align: center;
        }
        th {
            background-color: #f4f4f4;
        }
         .header {
            display: flex;
            align-items: center;
            justify-content: space-between; 
            margin-bottom: 50px;

        }

        .header .logo {
            display: flex;
            align-items: center;
        }

        .header .logo img {
            width: 50px;       
            object-fit: contain;
        }
        .user-info h2,h4 {
            color:#FBB108;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .user-info span {
            color: #000000;
        }
        .imprimer-button a {
            display: inline-block;
            margin-top: 10px;
            padding: 8px 16px;
            background-color: #FBB108;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
        }
        .user{
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<header class="header">
        <div class="logo">
            <img src="{{ asset('images/logo1.png') }}" alt="Logo">
        </div>
         
        <div>
        <h2>Rapport des Données d'Énergie</h2>


        </div>
        <div>
            <h1>Smart<span>Sol</span> </h1>
        </div>
        </header>
        <div class="user">
            <div class="user-info">
            <h2>Client Informations:<span>{{ (Auth::user()->name)}}</span></h2>
            <h4>Email:<span>{{ (Auth::user()->email)}}</span></h4>
        </div>
        <div class="imprimer-button">
        <a href="{{ route('admin.energy-data.print') }}">Imprimer</a>
        </div>
        </div>
    <table>
        <thead>
            <tr>
                <th>Panel ID</th>
                <th>Power</th>
                <th>Consumption</th>
                <th>Voltage</th>
                <th>Current</th>
                <th>Energy KWh</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($energyDatas as $data)
                <tr>
                    <td>{{ $data->panel_id }}</td>
                    <td>{{ $data->power }}</td>
                    <td>{{ $data->consumption }}</td>
                    <td>{{ $data->voltage }}</td>
                    <td>{{ $data->current }}</td>
                    <td>{{ $data->energy_kwh }}</td>
                    <td>{{ $data->created_at ? $data->created_at->format('H:i Y-m-d') : '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>