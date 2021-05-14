# TBNeo

## Sobre
Interface CRUD para projetos cadastrados no TBNeo para facilitar a identificação e gestão das features flags por projeto.

---

## Stack utilizada
- Laravel (PHP)
- Vue (JS)

### Gerenciamento de pacotes
- Composer
- NPM

---

## Instalação / Setup

1. Clone o repositório

```
git clone https://github.com/lordscorp/tbneo.git
```
<br>

2. Renomeie o arquivo `.env.example` para `.env` e altere as variáveis de ambiente (`local`/`staging`/`prod`) conforme as especificações do seu servidor (crie um banco de dados exclusivo para a aplicação)

<br>

3. Na pasta do projeto, instale as dependências do Composer
```
composer install
```
<br>

4. Instale as dependências do NPM
```
npm install
```
<br>

5. Gere uma chave de encriptação
```
php artisan key:generate
```
<br>

6. Migre o banco de dados
```
php artisan migrate
```


Pronto! Para executar a aplicação no servidor local (desenvolvimento), execute os comandos 
```
php artisan serve
npm run watch
```

---

## Rotas da API

URL Base (local): `http://localhost:8000/api/`

`/usuarios`: Retorna array com todos os usuários cadastrados;
```json
[
    {
        "id": 1,
        "name": "Renan Gomes",
        "email": "renan...",
        "email_verified_at": null,
        "created_at": null,
        "updated_at": null
    },
    {
        "id": 2,
        "name": "Fulano de tal",
        "email": "fulano@tal.com",
        "email_verified_at": null,
        "created_at": null,
        "updated_at": null
    },
    ...
]
```

`/projetos`: Retorna objeto com suporte a paginação que contém array de todos os projetos cadastrados

Opcional: pode ser acrescentada uma string como parâmetro de filtro de resultados por nome (`/projetos/{nome}`)

```json
{
"current_page": 1,
"data": [
    {
        "id": 1,
        "nome_projeto": "PROJETO 52",
        "descricao": "Projeto teste 52",
        "url_jira": "https://www.google.com",
        "criado_por": 1,
        "atualizado_por": 1,
        "created_at": "2021-05-13T04:33:18.000000Z",
        "updated_at": "2021-05-14T01:57:29.000000Z"
    },
    {
        "id": 2,
        "nome_projeto": "Outro projeto",
        "descricao": "Descrição nova",
        "url_jira": "http://link.io",
        "criado_por": 1,
        "atualizado_por": 1,
        "created_at": "2021-05-13T04:39:11.000000Z",
        "updated_at": "2021-05-14T01:02:43.000000Z"
    },
    {
        ...
    }
],
"first_page_url": "http://localhost:8000/api/projetos?page=1",
"from": 1,
"last_page": 2,
"last_page_url": "http://localhost:8000/api/projetos?page=2",
"links": [
    {
    "url": null,
    "label": "&laquo; Previous",
    "active": false
    },
    {
    "url": "http://localhost:8000/api/projetos?page=1",
    "label": "1",
    "active": true
    },
    {
    "url": "http://localhost:8000/api/projetos?page=2",
    "label": "2",
    "active": false
    },
    {
    "url": "http://localhost:8000/api/projetos?page=2",
    "label": "Next &raquo;",
    "active": false
    }
],
"next_page_url": "http://localhost:8000/api/projetos?page=2",
"path": "http://localhost:8000/api/projetos",
"per_page": 10,
"prev_page_url": null,
"to": 10,
"total": 18
}
```

Rotas complementares:

```php
Route::prefix('/projeto')->group(function () {
    Route::get('/{id}', [ProjetoController::class, 'show']);
    Route::post('/store', [ProjetoController::class, 'store']);
    Route::put('/{id}', [ProjetoController::class, 'update']);
    Route::delete('/{id}', [ProjetoController::class, 'destroy']);

    Route::get('/{id}/log', [LogsController::class, 'index']);

    Route::get('/{id}/features', [FeaturesController::class, 'index']);
});
```

Renan Moreira Gomes - https://github.com/lordscorp/