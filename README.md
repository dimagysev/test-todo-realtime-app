## Test RealTime ToDo App

 ```sh
git clone https://github.com/dimagysev/test-todo-realtime-app.git todo-app
```

### In project directory
#### step 1
```sh
docker-compose up -d
```
#### step 2
```sh
docker-compose exec app bash
```
#### step 3
```sh
composer install
```
#### step 4
```sh
cp .env.example .env
```
Add credentials for MAIL in .env
#### step 5
In src/config/todo.php add email addresses for notifications
#### step 6
```sh
php artisan queue:work
```


In app already created two users with credentials: user1/user1, user2/user2
