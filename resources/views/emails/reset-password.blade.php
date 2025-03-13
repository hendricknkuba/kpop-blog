<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinição de Senha</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .button {
            background-color: #007bff;
            color: white;
            padding: 12px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin-top: 20px;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Olá, {{ $user->name }}</h2>
        <p>Recebemos uma solicitação para redefinir sua senha.</p>
        <p>Para continuar, clique no botão abaixo:</p>
        <a href="{{ $resetUrl }}" class="button">Redefinir Senha</a>
        <p>Se você não solicitou essa alteração, ignore este e-mail.</p>
        <p class="footer">Este link expirará em 60 minutos.</p>
    </div>
</body>
</html>
