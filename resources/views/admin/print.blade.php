<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __("SmartSol | Liste D'utilisateur") }}</title>
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
            margin-bottom: 10px;

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
            <h2 class="text-">{{ __("Liste D'utilisateurs") }}</h2>

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
        <a href="{{ route('admin.users.print') }}">Imprimer</a>
        </div>
        </div>
    <table>
        <thead>
            <tr>
                <th>{{__("Nom D'utilisateur")}}</th>
                <th> {{__("Email")}}</th>
                <th>{{__("Telephone")}} </th>
                <th>{{ __('Date') }} </th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone_number }}</td>
                    <td>{{ $user->created_at ? $user->created_at->format('Y-m-d H:i') : '-' }}</td>
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