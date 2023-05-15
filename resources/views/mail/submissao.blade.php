<!DOCTYPE html>
<html>

<head>
    <title>Nova Submissão de Questionário!</title>
</head>

<body>
    <div>Foi registada uma nova submissão de questionário!</div>
    <div>Dados inseridos pelo Utilizador:</div><br>
    <div>Nome:{{ $nome }}</div>
    <div>Contacto:{{ $contacto }}</div>
    <div>Email:{{ $useremail }}</div>
    <div>Categorias:</div>
    @for ($i = 0; $i < count($categs); $i++)
        <div>{{ $categs[$i] }}
            <span>- Média:{{ $medias[$i] }}</span>
        </div>
    @endfor
    <div>Gráfico:</div>
    <div><img src="{{ $chart }}" alt=""></div>
</body>

</html>
