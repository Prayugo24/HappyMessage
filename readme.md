# Introduce For installation
After you clone this project, do the following:

```json 
{
    #go into the project
    cd HappyMessage

    # go into the project
    cd HappyMessage

    # create a .env file
    cp .env.example .env

    # install composer dependencies
    composer update

    # create a local MySQL database (make sure you have MySQL up and running)
    create db with name db chat_db

    # add the database connection config to your .env file
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_CONNECTION=mysql
    DB_DATABASE=chat_db
    DB_USERNAME=root
    DB_PASSWORD=

    # run the migration files to generate the schema
    php artisan migrate
}
```


# API Spec

## Authentication

All API must use this authentication

Request :
- Header :
    - X-Api-Key : "your secret api key"

## Create Product

Request :
- Method : POST
- Endpoint : `/api/products`
- Header :
    - Content-Type: application/json
    - Accept: application/json
- Body :

```json 
{
    "id" : "string, unique",
    "name" : "string",
    "price" : "long",
    "quantity" : "integer"
}
```

Response :

```json 
{
    "code" : "number",
    "status" : "string",
    "data" : {
         "id" : "string, unique",
         "name" : "string",
         "price" : "long",
         "quantity" : "integer",
         "createdAt" : "date",
         "updatedAt" : "date"
     }
}
```

## Get Product

Request :
- Method : GET
- Endpoint : `/api/products/{id_product}`
- Header :
    - Accept: application/json

Response :

```json 
{
    "code" : "number",
    "status" : "string",
    "data" : {
         "id" : "string, unique",
         "name" : "string",
         "price" : "long",
         "quantity" : "integer",
         "createdAt" : "date",
         "updatedAt" : "date"
     }
}
```
