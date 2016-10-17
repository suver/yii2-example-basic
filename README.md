Yii 2 Basic Project Template
============================


Другое
------

# Модуль уведомлений #

Способы установки и работы с модулем уведомлений описаны тут [yii2-notifications](https://github.com/suver/yii2-notifications)




Требования
----------

Минимальные требования

* PHP 5.6.0.

* MySQL 5.6.0.

* Yii2 latest

* composer


INSTALLATION
------------

### Установка

Запустить команду

~~~
php composer.phar install


php composer.phar update // для обновления версий некоторых библиотек 

~~~

Now you should be able to access the application through the following URL, assuming `basic` is the directory
directly under the Web root.

~~~
http://localhost/
~~~


### Установить RBAC


```bash

yii migrate

yii migrate --migrationPath=@yii/rbac/migrations/

php yii rbac/init


```

### Настройка Apache

```
<VirtualHost *:80>
        ServerAdmin support@tekecorp.ru
        ServerName t3.example.com
        DocumentRoot /com/example/t3/web

        <Directory />
                Options Indexes FollowSymLinks
                AllowOverride All
        </Directory>
        <Directory "/com/example/t3/web" >

                RewriteEngine on
                RewriteCond %{REQUEST_FILENAME} !-f
                RewriteCond %{REQUEST_FILENAME} !-d
                RewriteRule . index.php

                Options Indexes FollowSymLinks MultiViews
                AllowOverride All
                Order allow,deny
                allow from all
                Require all granted
        </Directory>
        ErrorLog ${APACHE_LOG_DIR}/error-t3.log

        # Possible values include: debug, info, notice, warn, error, crit,
        # alert, emerg.
        LogLevel info

        CustomLog ${APACHE_LOG_DIR}/access-t3.log combined
</VirtualHost>


```


Если ваш алиас указан как `Yii::setAlias('@storage', dirname(__DIR__) . '/storage');` нужно добавить алиса для Apache

```

        Alias /storage/ /com/example/t3/storage/
        <Directory /storage/>
                Options Indexes FollowSymlinks
                AllowOverride All
                Order allow,deny
                Allow from all
        </Directory>
```

Укажите домен в настройках расширения `suver\yii2-uploads`

```
        'uploads' => [
            'class' => 'suver\behavior\upload\Module',
            'storageDomain' => '//newsfeed.dev/storage'
        ],

```



### Установить модули

Install module and run migrations

* [yii2-settings](https://github.com/suver/yii2-settings)
* [yii2-notifications](https://github.com/suver/yii2-notifications)
* [yii2-behavior-upload](https://github.com/suver/yii2-behavior-upload)
* [yii2-editor](https://github.com/suver/yii2-editor)
* [yii2-behavior-subset](https://github.com/suver/yii2-behavior-subset)


```
yii migrate --migrationPath=@vendor/suver/yii2-settings/migrations

yii migrate --migrationPath=@vendor/suver/yii2-notifications/migrations

yii migrate --migrationPath=@vendor/suver/yii2-behavior-upload/migrations

```


### Установить миграции


```bash
yii migrate --migrationPath=@app/modules/users/migrations


yii migrate --migrationPath=@app/modules/newsFeed/migrations

```


### Cron

Добавьте в крон команду для отправки email

./yii email-send


### Postinstall

```

chmod -R 777 ./web/assets/

chmod -R 777 ./runtime/


```

**ВНИМАНИЕ после установки необходимо загрузить дамп шаблонов из файла suver_notifications_template.sql**

К сожелению так как эти даннные должны быть внесены в самом конце, в миграции в данной версии их запихнуть невозможно

Только после этого можно регистрироватся

После регистрации первого пользователя его необходимо сделать админом. Для этого нужно измениь в таблице auth_assignment значение item_name для свого user_id

Пример

```
UPDATE `auth_assignment` SET `item_name` = 'admin' WHERE `item_name` = 'user' AND `user_id` = '4';
```





CONFIGURATION
-------------

Настраиваем подключения к БД и работу уведомлений

```php

// web
'notifications' => [
    'class' => 'suver\notifications\Module',
    'detailViewWidget' => '\app\widgets\DetailView',
    'gridViewWidget' => '\app\widgets\GridView',
    'identityClass' => '\app\models\User',
    'channels' => [
        [
            'class' => '\suver\notifications\EmailChannel',
            'init' => [
                'from' => 'mail@example.com',
            ],
            'config' => [
                'class' => 'yii\swiftmailer\Mailer',
                'transport' => [
                    'class' => 'Swift_SmtpTransport',
                    'host' => 'smtp.yandex.ru',
                    'username' => 'mail@example.com',
                    'password' => '****',
                    'port' => '465',
                    'encryption' => 'ssl',
                ],
            ],
        ],
        [
            'class' => '\suver\notifications\FlashNotificationsChannel',
            'init' => [
                'key' => 'info',
            ],
            'config' => [],
        ],
    ],
];
    
// db
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2basic',
    'username' => 'test',
    'password' => 'test',
    'charset' => 'utf8',
];
```



TESTING
-------

Tests are located in `tests` directory. They are developed with [Codeception PHP Testing Framework](http://codeception.com/).
By default there are 3 test suites:

- `unit`
- `functional`
- `acceptance`

Tests can be executed by running

```
composer exec codecept run
``` 

The command above will execute unit and functional tests. Unit tests are testing the system components, while functional
tests are for testing user interaction. Acceptance tests are disabled by default as they require additional setup since
they perform testing in real browser. 


### Running  acceptance tests

To execute acceptance tests do the following:  

1. Rename `tests/acceptance.suite.yml.example` to `tests/acceptance.suite.yml` to enable suite configuration

2. Replace `codeception/base` package in `composer.json` with `codeception/codeception` to install full featured
   version of Codeception

3. Update dependencies with Composer 

    ```
    composer update  
    ```

4. Download [Selenium Server](http://www.seleniumhq.org/download/) and launch it:

    ```
    java -jar ~/selenium-server-standalone-x.xx.x.jar
    ``` 

5. (Optional) Create `yii2_basic_tests` database and update it by applying migrations if you have them.

   ```
   tests/bin/yii migrate
   ```

   The database configuration can be found at `config/test_db.php`.


6. Start web server:

    ```
    tests/bin/yii serve
    ```

7. Now you can run all available tests

   ```
   # run all available tests
   composer exec codecept run

   # run acceptance tests
   composer exec codecept run acceptance

   # run only unit and functional tests
   composer exec codecept run unit,functional
   ```

### Code coverage support

By default, code coverage is disabled in `codeception.yml` configuration file, you should uncomment needed rows to be able
to collect code coverage. You can run your tests and collect coverage with the following command:

```
#collect coverage for all tests
composer exec codecept run -- --coverage-html --coverage-xml

#collect coverage only for unit tests
composer exec codecept run unit -- --coverage-html --coverage-xml

#collect coverage for unit and functional tests
composer exec codecept run functional,unit -- --coverage-html --coverage-xml
```

You can see code coverage output under the `tests/_output` directory.
