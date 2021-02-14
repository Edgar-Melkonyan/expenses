# Expenses Api

Please find how to launch the application and the structure of the API bellow.



## Application launching

	1) cp .env.example .env
	2) docker-compose build --no-cache
	3) docker-compose up -d  
	4) docker-compose exec app php artisan key:generate
    5) docker-compose exec app php artisan migrate --seed
    6) docker-compose exec app php artisan passport:install
    7) to run test docker-compose exec app composer test

## Api structure

- URL  
	- /api/login/
- HTTP Method  
	- POST
- Operation  
	- Login
- Api Call Example  
	- api/login	
    - Request Body
    ```
    email 
    password
    
## 


- URL  
	- /api/logout/
- HTTP Method  
	- POST
- Operation  
	- Logout
- Api Call Example  
	- api/logout

## 
- URL  
	- /api/users
- HTTP Method  
	- GET
- Operation  
	- Select all users and return paginated results
- Api Call Example  
	- api/users

## 

- URL  
	- /api/users/{user}
- HTTP Method  
	- GET
- Operation  
	- Select user
- Api Call Example  
	- api/users/1

## 

- URL  
	- /api/users
- HTTP Method  
	- POST
- Operation  
	- Create user
- Api Call Example  
	- api/users
- Request Body
    ```
    name
    email 
    password
    password_confirmation
    role_id

## 

- URL  
	- /api/users/{user}
- HTTP Method  
	- PUT
- Operation  
	- Update user
- Api Call Example  
	- api/users/1
- Request Body
    ```
    name
    email 
    password
    password_confirmation
    role_id
 
## 
 
- URL  
	- /api/users/{user}
- HTTP Method  
	- DELETE
- Operation  
	- Delete user
- Api Call Example  
	- api/users/1
 
 ## 

- URL  
	- /api/expenses
- HTTP Method  
	- GET
- Operation  
	- Select all expenses and return paginated results
- Api Call Example  
	- api/expenses

## 

- URL  
	- /api/expenses/{expense}
- HTTP Method  
	- GET
- Operation  
	- Select expense
- Api Call Example  
	- api/expenses/1

## 

- URL  
	- /api/expenses
- HTTP Method  
	- POST
- Operation  
	- Create expense
- Api Call Example  
	- api/expenses
- Request Body
    ```
    amount 

## 

- URL  
	- /api/expenses/{expense}
- HTTP Method  
	- PUT
- Operation  
	- Update expense
- Api Call Example  
	- api/expenses/1
- Request Body
    ```
   amount
   
## 

- URL  
	- /api/expenses/{expense}
- HTTP Method  
	- DELETE
- Operation  
	- Delete expense
- Api Call Example  
	- api/expenses/1

 
 ## 
- URL  
	- /api/export-expenses
- HTTP Method  
	- POST
- Operation  
	- Export expenses
- Api Call Example  
	- api/export-expenses

 ## 
- URL  
	- /api/statistics/yearly
- HTTP Method  
	- GET
- Operation  
	- Get statistics of the requested year
- Api Call Example  
	- /api/statistics/yearly?year=2021

 ## 
- URL  
	- /api/statistics/monthly
- HTTP Method  
	- GET
- Operation  
	- Get statistics of the requested month
- Api Call Example  
	- /api/statistics/monthly?year=2020&month=1