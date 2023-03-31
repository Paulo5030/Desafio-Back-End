# Docker Laravel para uma micro aplicação de carteira

  Auth 
  - Autenticação com o Passport 
  - Coverage 90% em autenticação (Controller/Repository)

 Transaction
 - Logistas não podem fazer uma tranferencia 
 - Criar uma transferencia de uma conta para outra 

  Componentes
 - NGINX 
 - MYSQL 
 - PHP8.1.0
 - Docker20.10.22

Acesso
 - A aplicação
 >http://localhost:8000/

Mysql
 - Host: locahost
 - Port: 3307
 - User: homestead
 - Password: secret

1. Obter o projeto
 - git clone https://github.com/Paulo5030/Desafio-Picpay.git

# Comandos
- Rodar composer install no projeto
>docker-compose run --rm composer install 

- Rodar composer update no projeto
>docker-compose run --rm composer update

- Para gerar as migrations
>php aritsan migrate

- Para gerar as sementes do banco de dados
>php aritsan migrate:fresh --seed

- Para executar os testes da aplicação
>vendor/bin/phpunit

- Caso a rota da aplicação de um erro de permissão
>php artisan route:clear

>php artisan config:clear

>php artisan cache:clear