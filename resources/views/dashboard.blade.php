<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Painel administrativo do TB NEO">
    <title>TB NEO</title>
    <!-- <link rel="stylesheet" href="{{ URL::asset('css/custom.css') }}" type="text/css" /> -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}" type="text/css" />
</head>

<body>
    <!-- MENU SUPERIOR -->
    <div id="menu-superior" class="row">
        <div class="col">
            <img src="/img/ul_menu.png" alt="Placeholder">
        </div>
        <div class="col-auto">
            <img src="/img/ur_menu.png" alt="Placeholder">
        </div>
    </div>
    <div class="row mh-100">
        <!-- MENU LATERAL -->
        <div id="menu-lateral" class="col-2 vh-100">
            <a href="#">Dashboard</a>
            <span>Parametrizações</span>
            <a href="#">Geral</a>
            <span>Feature Flags</span>
            <a href="#">Infra</a>
            <a href="#">Demais Sistemas</a>
            <a href="/lista-projetos" class="selecionado">Projetos</a>
            <span>Acessos</span>
            <a href="#">Acesso</a>

        </div>
        <div class="col app-container">
            <div id="app"></div>
        </div>
    </div>
    <style>
        .app-container {
            background-color: #ddd;
        }

        body {
            margin: 0;
            overflow: hidden;
        }

        #menu-lateral {
            background-color: #2f353a;
            color: #eee;
            font-family: Arial, Helvetica, sans-serif;
        }

        #menu-lateral a {
            color: #eee;
            text-decoration: none;
        }

        #menu-lateral a::before {
            content: "_";
            width: 5px;
            height: 3px;
            line-height: 2px;
            border: 1px solid #888;
            color: #888;
            font-size: 10px;
            margin-right: 15px;
        }

        #menu-lateral>* {
            display: block;
            margin: 0;
            padding: 18px 10px;
        }

        #menu-lateral>span {
            text-transform: uppercase;
            font-size: 0.8em;
        }

        #menu-lateral>*:hover,
        #menu-lateral .selecionado {
            background-color: rgba(255, 255, 255, 0.1);
        }
        td {
            padding: 4px 10px !important;
        }
        a {
            color: red;
            text-decoration: none;
        }
    </style>
    <script src="{{ mix('js/app.js') }}" type="text/javascript"></script>
</body>

</html>