# Personal-Accounting

## To run this test task, please follow the below steps after clone the project from github.

1. Duplicate `.env.example` file to `.env` file, and config DB settings.
2. 
```
composer install
```
3.
```
php artisan key:generate
```
4.
```
php artisan db:create personal_accounting
```
5.
```
php artisan migrate
```
6. (account for test: [email => test@example.com, password => password])
```
php artisan db:seed
```
7.
```
php artisan serve
```

## API endpoints

```
login:
URI: {{baseurl}}/api/login
Method: POST
Payload: email, password
```

## 🤣 Enjoy 🤣