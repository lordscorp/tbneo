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
## Testes

### Testes unitários e de integração
```
php artisan test
```

### Testes e2e
```
npm run test
```