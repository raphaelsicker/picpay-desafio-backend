# Desafio Raphael Goulart de Siqueira
Esse sistema consiste numa api para transferência de valores entre um ou mais usuários.

# Desenvolvido com

    Laravel 7.24.0

# Requisitos

    PHP >= 7.2
    BCMath PHP Extension
    Ctype PHP Extension
    Fileinfo PHP extension
    JSON PHP Extension
    Mbstring PHP Extension
    OpenSSL PHP Extension
    PDO PHP Extension
    Tokenizer PHP Extension
    XML PHP Extension
    
## Ambiente de desenvolvimento

Este projeto foi feito utilizando Docker já integrado no repositorio, sendo necessário apenas rodar o seguinte comando pelo terminal na pasta inicial do projeto:
    
    docker-composer up

## Instalação do projeto
* Para que o sistema funcione basta apenas copiar o arquivo .env.example para .env. 
As configurações padrões já estarão no arquivo .env mas é possível alterar essas configurações com as seguintes variaveis:
  
        
    DB_CONNECTION=seu-db
    DB_HOST=host
    DB_PORT=porta
    DB_DATABASE=nome-do-banco
    DB_USERNAME=seu-login
    DB_PASSWORD=sua-senha

* Execute os seguintes comandos 

   
    composer install
    php artisan key:generate
    php artisan migrate

## Testes

Supondo que a pasta do repositorio seja picpay, é possível rodar os scripts de teste da aplicação utilizando o seguinte comando para acessar a imagem web do docker:

    docker exec -it picpay_web_1 bash
    
E a seguir:
    
    docker exec -it picpay_web_1 bash
    

    
