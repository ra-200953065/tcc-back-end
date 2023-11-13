<!DOCTYPE html>
<html>

<head>
    <title>{{ $mailData['title'] }}</title>
</head>

<body>
    <h4>{{ $mailData['body'] }}</h4>

    @isset($mailData['link'])
    <a href="{{ $mailData['link'] }}" target="_blank">Clique aqui para alterar sua senha</a>
    @endisset

    <p>Obrigado!</p>
</body>

</html>