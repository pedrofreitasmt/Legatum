<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Legatum - Contato enviado por {{ $data['name'] }}</title>
</head>
<body>
    <h1>Email enviado automaticamente - não responda este email.</h1>

    <h2>Título - {{ $data['title'] }}</h2>

    <h2>Conteúdo</h2>
    <p>{{ $data['content'] }}</p>
</body>
</html>
