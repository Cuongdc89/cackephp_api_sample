# Init project 
- This project using cakephp-docker for setup env
- Please install docker and docker composer then execute the following commands
- Clone this repository to your machine 
- cd to docker folder, then run command to start docker container
  - ```docker-compose up -d```
- Access to **myapp-php-fpm** container 
  - ```docker-compose exec myapp-php-fpm bash```
- Set permission for user www-data
  - ``` chown -R www-data:www-data ```
- Run migration 
  - ```bin/cake migrations migrate```
- Run seeder 
  - ```bin/cake migrations seed --seed UsersSeed```
- Access the following URL on the browser:  http://localhost:8180/ , You will see the CakePHP home page displayed.

# Code structure

```angular2html
-- cakephp: application folder
    |-- Config: Folder containing project configuration information
        |-- Migrations: Folder containing migration files
            |-- 20241126023321_CreateUsers: migrate file for users table
        |-- Seeds: Folder containing seed data files
            |-- UsersSeed: Seeder data file for users table
        |-- router: Contains router to APIs endpoint
    |-- src: Folder containing logic code
        |-- Controller
            |-- Api
                |-- UsersController: Logic of the APIs interacting with the user object
        |-- Model
            |-- Table
                |-- UsersTable: model user 
        |-- Repository
            |-- Interfaces
                |-- UserRepositoryInterface: Interface define common function in UserRepository 
            |-- UserRepository: Contain methods for interacting with User model  
        |-- Validator
            |-- UserValidator: validate input data for User model
-- docker: docker config directory

```


# API Documentation
## POST /api/user.json - Create new user

### Description
This API allows you to create a new user in the system.

### HTTP Method
_**POST**_

### URL
_/api/user.json_

### Request Body
The data to create a new user, formatted as JSON.

```angular2html
{
  "username": "john_doe",
  "email": "john.doe@example.com"
}

```

#### Fields
username: (string, required)
email (string, required, unique): The user's email address.

### Response
#### Success (HTTP Status 200)
If the user is created successfully, the API will return a 201 Created status with the newly created user data.
```angular2html
{
    "status": "success",
    "message": "User created successfully"
}

```

#### Error
If there is an error with the submitted data (e.g., email already exists, invalid email), the API will return an error status with a description of the issue.

```angular2html
{
  "status": "error",
  "message": "Validation failed",
  "errors": {
    "email": "Email is already in use",
    "password": "Password must be at least 8 characters"
  }
}

```

## GET /api/user.json - Retrieve list user information
### Description
This API allows you to retrieve detailed information about a user from the system.

### HTTP Method
**_GET_**

### URL
_/api/user.json_

### Query Parameters
- page: (int, option) page number to get
- limit: (int, option) number of user per page

#### Example URL
_GET /api/user.json?page=2&limit=10_

http://localhost:8180/api/users.json?page=1&limit=2

### Response
#### Success (HTTP Status 200)
If the user exists, the API will return the user's detailed information.

```angular2html
{
    "status": "success",
    "data": [
      {
        "id": 1,
        "name": "User 1",
        "email": "user1@example.com",
        "created": "2024-11-26T04:32:11+00:00",
        "modified": "2024-11-26T04:32:11+00:00"
      },
      {
        "id": 2,
        "name": "User 2",
        "email": "user2@example.com",
        "created": "2024-11-26T04:32:11+00:00",
        "modified": "2024-11-26T04:32:11+00:00"
        }
      ],
      "pagination": {
      "total": 101,
      "next_page": 2,
      "per_page": 2
      }
}
```

#### Error 
```angular2html
{
  "status": "error",
  "message": "Failed to get user list data"
}
```






