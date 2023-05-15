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

1. Obter o projeto
 - git clone https://github.com/Paulo5030/Desafio-Picpay.git

Acesso
 - A aplicação
 >http://localhost:8000/

Mysql
 - Host: localhost
 - Port: 3307
 - User: homestead
 - Password: secret

Exemplo - Payload:

```bash
{
    "provider" : "user",
    "payee_id" : "4",
    "amount" : 15
    
}
```

Exemplo - Resposta:

```bash
{
    "id": "1",
    "payer_wallet_id": "2",
    "payee_wallet_id": "3",
    "amount": 15,
    "created_at": "14/05/2023 01:45:34"
}
```

# Comandos
- Rodar composer install no projeto
```bash
docker-compose run --rm composer install
```

- Rodar composer update no projeto
```bash
docker-compose run --rm composer update
```


- Para gerar as migrations
```bash
php aritsan migrate
```

- Para gerar as sementes do banco de dados
```bash
php aritsan migrate:fresh --seed
```

- Para executar os testes da aplicação
```bash
 vendor/bin/phpunit
```
- Para executar o grumphp
```bash
 /vendor/bin/grumphp run
```

- Caso a rota da aplicação de um erro de permissão
```bash
php artisan route:clear
```
```bash
php artisan config:clear
```
```bash
php artisan cache:clear
```