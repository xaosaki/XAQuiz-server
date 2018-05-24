<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>XAQuiz</title>
        <link href="https://fonts.googleapis.com/css?family=Cormorant+Garamond:400,700&amp;subset=cyrillic,latin" rel="stylesheet">
        <style>
            body{
                font-family: 'Cormorant Garamond', 'Arial', serif;
                background: #fdfdfd;
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                justify-items: center;
                justify-content: center;
                align-content: center;
                height: 100vh;
            }
            .content{
                text-align: center;
            }
            h1{
                font-size: 150px;
                margin-bottom: 40px;
                margin-top: -140px;
                color: #f77831;
                background-image: -webkit-linear-gradient(92deg,#f35626,#ffaf43);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }
            p{
                font-size: 30px;
                color: #7070ad;
            }
            a{
                color: #f77831;
                font-size: 30px;
                text-decoration: none;
            }
            a:hover{
                border-bottom: 1px dotted;
            }
        </style>
    </head>
    <body>
        <div class="content">
            <h1>Quiz</h1>
            @auth
                <a href="{{ url('/home') }}" class="content">Выбрать тест</a>
            @else
                <p>Для начала работы <a href="{{ route('login') }}">войдите</a> или <a href="{{ route('register') }}">зарегистрируйтесь</a>.</p>
            @endauth
        </div>
    </body>
</html>
