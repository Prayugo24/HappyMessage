# Introduce For installation
After you clone this project, do the following:

```bash
    #go into the project
    cd HappyMessage

    # create a .env file
    cp .env.example .env

    # install composer dependencies
    composer update

    # create a local MySQL database (make sure you have MySQL up and running)
    create db with name db chat_db in your mysql

    # add the database connection config to your .env file
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_CONNECTION=mysql
    DB_DATABASE=chat_db
    DB_USERNAME=root
    DB_PASSWORD=

    # run the migration files to generate the schema
    php artisan migrate

    # For run application you can use php artisan (for port you can decide for yourself)
    php -S localhost:8000 -t public
```


# Api Spesification

## Authentication

some Api features must use this authentication

Request :
- Header :
    - X-Token : "get scret token in tabel user, in raw remember token"

## Register User

Request :
- Method : POST
- Endpoint : `/V1/Register`
- Header :
    - Content-Type: application/json
- Body :

```json 
{
    "params":{
	   "name":"string",
	   "email":"string",
	   "password_1":"string",
	   "password_2":"string"
    }
}
```

Response :

```json 
{
    "API_Message": {
        "Version": "V1",
        "Times": "Times",
        "NameEnd": "string",
        "Status": "string",
        "Message": {
            "Type": "string",
            "ShortText": "string",
            "Speed": "float",
            "Code": "number"
        },
        "Body": {
            "Result": {
                "email": "string",
                "name": "string",
                "profile_image": "string",
                "remember_token": "string"
            }
        }
    }
}
```

## Login User

Request :
- Method : POST
- Endpoint : `/V1/Login`
- Header :
    - Content-Type: application/json
- Body :

```json 
{
    "params":{
       "email":"string",
       "password":"string"
   }
}
```

Response :

```json 
{
    "API_Message": {
        "Version": "V1",
        "Times": "Times",
        "NameEnd": "string",
        "Status": "string",
        "Message": {
            "Type": "string",
            "ShortText": "string",
            "Speed": "float",
            "Code": "number"
        },
        "Body": {
            "Result": {
                "email": "string",
                "name": "string",
                "profile_image": "string",
                "remember_token": "string"
            }
        }
    }
}
```
## Send Message

Request :
- Method : POST
- Endpoint : `/V1/SendMessage`
- Header :
    - Content-Type: application/json
    - X-Token: 'remember_token'
- Body :

```json 
{
    "params":{
      "from":"email",
      "to":"email",
      "message":"string"
    }
}
```

Response :

```json 
{
    "API_Message": {
        "Version": "V1",
        "Times": "Times",
        "NameEnd": "string",
        "Status": "string",
        "Message": {
            "Type": "string",
            "ShortText": "string",
            "Speed": "float",
            "Code": "number"
        },
        "Body": {
            "Result": {
                "id": "int",
                "from": "int",
                "to": "int",
                "text": "string",
                "created_at": "times",
                "updated_at": "times"
            }
        }
    }
}
```

## Receive Message Single List

Request :
- Method : POST
- Endpoint : `/V1/ReceiveMessage`
- Header :
    - Content-Type: application/json
    - X-Token: 'remember_token'
- Body :

```json 
{
    "params":{
       "from":"email",
       "to":"email",
    }
}
```

Response :

```json 
{
    "API_Message": {
        "Version": "V1",
        "Times": "Times",
        "NameEnd": "string",
        "Status": "string",
        "Message": {
            "Type": "string",
            "ShortText": "string",
            "Speed": "float",
            "Code": "number"
        },
        "Body": {
            "Result": [
                {
                    "id": "int",
                    "FromName": "string",
                    "ToName": "string",
                    "Text": "string",
                    "Time": "times"
                }
            ]
        }
    }
}
```

## List All Message

Request :
- Method : POST
- Endpoint : `/V1/ListMessage`
- Header :
    - Content-Type: application/json
    - X-Token: 'remember_token'
- Body :

```json 
{
    "params":{
       "email":"email",
    }
}
```

Response :

```json 
{
    "API_Message": {
        "Version": "V1",
        "Times": "Times",
        "NameEnd": "string",
        "Status": "string",
        "Message": {
            "Type": "string",
            "ShortText": "string",
            "Speed": "float",
            "Code": "number"
        },
        "Body": {
            "Result": [
                {
                    "id": "int",
                    "Name": "string",
                    "email": "string",
                    "Text": "string",
                    "Time": "times"
                }
            ]
        }
    }
}
```




