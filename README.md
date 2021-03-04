# DS Brigade Teste

Webscrapping de dados de sites públicos feito com NodeJS e visualização dos mesmos em um ambiente web desenvolvido com Laravel 8.

Pré-requisitos: Ter o NodeJS, PostgreSQL, PHP e Laravel previamente instalados.

## Instalação

Dentro da raiz do projeto rode o comando:
```bash
npm install
```
Esse comando irá instalar todos os pacotes do NodeJS necessários para o Webscrapping das informações.

Ainda dentro da raiz do projeto, crie um arquivo chamado .env, seguindo o modelo abaixo(disponível também no arquivo .env.example na raiz do projeto):

```bash

DB_CONNECTION=pgsql
DB_HOST=localhost
DB_PORT=5432
DB_DATABASE=dsbrigade
DB_USERNAME=postgres
DB_PASSWORD="SUA_SENHA_AQUI"

```

Preencha os campos com o seus dados de conexão com o PostgreSQL.


No diretório webapp/dsbrigade execute o comando 
```bash
composer install
```

Em seguida crie uma base de dados chamada dsbrigade no seu PostgreSQL, em seguida execute o comando abaixo no seu terminal:

```bash
php artisan migrate
```
Ele irá criar a tabela necessária para executar o Webscrapping(não esqueça de preencher corretamente os dados de conexão do seu banco PostgreSQL no arquivo .env localizado na raiz do projeto Laravel(webapp/dsbrigade)).


## Utilização

Para executar o Webscrapping das informações e popular o banco de dados, no seu terminal, navegue até o diretório raiz do projeto e execute o comando:

```bash
node collect.js
```
Aguarde até o fim da execução(quando parar de exibir dados no terminal)


E por fim, para levantar seu servidor PHP e visualizar os dados, execute o comando:

```bash
php artisan serve
```

Feito isso você poderá acessar a aplicação para visualização dos dados extraídos através do seu localhost, normalmente fica no endereço http://127.0.0.1:8000.


## Contribuindo

Solicitações pull são bem-vindas. Para mudanças importantes, abra um problema primeiro para discutir o que você gostaria de mudar.

## Licença
[MIT](https://choosealicense.com/licenses/mit/)