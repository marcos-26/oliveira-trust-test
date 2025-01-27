<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>


Projeto de Upload de Arquivo e Processamento de Dados
Este projeto fornece uma API para fazer o upload de arquivos, salvar informações no banco de dados (MongoDB), e buscar essas informações. O sistema processa arquivos CSV e armazena dados relacionados a várias entidades, como RptDt, TckrSymb, MktNm, SctyCtgyNm, ISIN, e CrpnNm.

Requisitos
PHP 8.x
Laravel 8.x ou superior
MongoDB
Composer
Extensão PHP MongoDB instalada
Instalação
Clone o repositório:

bash

git clone https://github.com/marcos-26/oliveira-trust-test.git
Instale as dependências do Composer:

bash

cd seu-repositorio
composer install

Configure seu docker 
docker-compose up -d --build 

Configure seu .env para usar MongoDB:

DB_CONNECTION=mongodb
DB_HOST=127.0.0.1
DB_PORT=27017
DB_DATABASE=nome_do_banco


php artisan migrate
Inicie o servidor:


php artisan serve
Agora você pode acessar a API no http://localhost:8000.

Rotas da API
1. POST /api/upload
Este endpoint é responsável por realizar o upload de arquivos CSV. Ele processa os dados e os armazena no banco de dados.

Corpo da Requisição
file (obrigatório): Arquivo CSV (com extensão .csv).
Exemplo de Requisição (Usando Postman ou cURL)

curl -X POST -F "file=@caminho/do/seu/arquivo.csv" http://localhost:8000/api/upload
Resposta
200 OK: Arquivo processado e dados salvos com sucesso.
400 Bad Request: Se o arquivo já foi enviado ou se ocorrer algum erro ao processar o arquivo.
Exemplo de Resposta
json

{
    "message": "Dados salvos com sucesso"
}
2. GET /api/history
Este endpoint retorna o histórico de uploads realizados.

Parâmetros de Consulta (opcionais)
filename (opcional): Filtra os uploads pelo nome do arquivo.
reference_date (opcional): Filtra os uploads pela data de referência.
Exemplo de Requisição

curl -X GET "http://localhost:8000/api/history?filename=seuarquivo.csv"
Resposta
200 OK: Retorna um array de uploads.
Exemplo de Resposta
json

[
    {
        "_id": "ObjectId(6797c7e2686a1db45508ab01)",
        "filename": "seuarquivo.csv",
        "reference_date": "2025-01-27",
        "uploaded_at": "2025-01-27T14:52:34.425-0300",
        "created_at": "2025-01-27T14:52:34.425-0300",
        "updated_at": "2025-01-27T14:52:34.425-0300"
    }
]
3. GET /api/search
Este endpoint permite buscar os dados processados do arquivo.

Parâmetros de Consulta (opcionais)
TckrSymb (opcional): Filtra os dados pelo valor de TckrSymb.
RptDt (opcional): Filtra os dados pelo valor de RptDt.
Exemplo de Requisição
bash
Copiar
Editar
curl -X GET "http://localhost:8000/api/search?TckrSymb=AMZO34"
Resposta
200 OK: Retorna os dados encontrados com base nos parâmetros de consulta.
Exemplo de Resposta
json

{
    "data": [
        {
            "_id": "ObjectId(6797c7e2686a1db45508ab01)",
            "rptDt": { "value": "2024-08-27" },
            "tckrSymb": { "value": "AMZO34" },
            "mktNm": { "value": "EQUITY-CASH" },
            "sctyCtgyNm": { "value": "BDR" },
            "isin": { "value": "BRAMZOBDR002" },
            "crpnNm": { "value": "AMAZON.COM" }
        }
    ],
    "links": {
        "first": "http://localhost:8000/api/search?page=1",
        "last": "http://localhost:8000/api/search?page=1"
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "per_page": 20,
        "to": 1,
        "total": 1
    }
}
Estrutura do Banco de Dados (MongoDB)
Os dados são armazenados no MongoDB na coleção files com a seguinte estrutura:

json

{
    "_id": ObjectId("6797c7e2686a1db45508ab01"),
    "rptDt": { "value": "2024-08-27" },
    "tckrSymb": { "value": "AMZO34" },
    "mktNm": { "value": "EQUITY-CASH" },
    "sctyCtgyNm": { "value": "BDR" },
    "isin": { "value": "BRAMZOBDR002" },
    "crpnNm": { "value": "AMAZON.COM" },
    "created_at": ISODate("2025-01-27T14:52:34.425-0300"),
    "updated_at": ISODate("2025-01-27T14:52:34.425-0300")
}
