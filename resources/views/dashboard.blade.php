<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Painel administrativo do TB NEO">
    <title>TB NEO</title>
    <link rel="stylesheet" href="{{ URL::asset('css/custom.css') }}" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
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
    <script src="{{ mix('js/app.js') }}" type="text/javascript"></script>
</body>

</html>