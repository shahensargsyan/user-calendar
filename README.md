# INSTALLATION 
This project runs with yiisoft/yii2-app-advanced

## Getting started

``` bash
$ git clone https://github.com/shahensargsyan/user-calendar.git
 
#move to directorys
$ cd user-calendar
$ docker-compose up -d --build

in common/config/main-local.php file correct db credentials

        'db' => [
            'class' => \yii\db\Connection::class,
            'dsn' => 'mysql:host=mysql;dbname=yii2advanced',
            'username' => 'yii2advanced',
            'password' => 'secret',
            'charset' => 'utf8',
        ],

# droping database if exist and creating new database
$ docker exec yii-application-mysql-1 mysql -u yii2advanced -psecret -e "drop schema yii2advanced;"
$ docker exec yii-application-mysql-1 mysql -u yii2advanced -psecret -e "create schema yii2advanced;"

#updating composer
$ docker exec yii-application-backend-1 bash -c "composer update"

# run migrations
$ docker exec yii-application-backend-1 bash -c " yes | php yii migrate --migrationPath=@yii/rbac/migrations;"
$ docker exec yii-application-backend-1 bash -c " yes | php yii migrate"
```

Open admin panel  http://localhost:21080

You can login with these users, password is same for all users: 123456789

administrator, ivan, aleksey, artyom, masha, lena, sasha, katya, pavel, elena.

You can create new users in http://localhost:20080 front side

