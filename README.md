Yii 2 Basic Project Template
============================



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

~~~

Now you should be able to access the application through the following URL, assuming `basic` is the directory
directly under the Web root.

~~~
http://localhost/
~~~


### Установить RBAC


```bash
yii migrate --migrationPath=@yii/rbac/migrations/

php yii rbac/init

```



### Установить модули

Install module and run migrations

* [yii2-settings](https://github.com/suver/yii2-settings)
* [yii2-notifications](https://github.com/suver/yii2-notifications)
* [yii2-behavior-upload](https://github.com/suver/yii2-behavior-upload)
* [yii2-editor](https://github.com/suver/yii2-editor)
* [yii2-behavior-subset](https://github.com/suver/yii2-behavior-subset)




### Установить миграции


```bash
yii migrate --migrationPath=@app/modules/users/migrations


yii migrate --migrationPath=@app/modules/newsFeed/migrations

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


Другое
------

# Модуль уведомлений #

Способы установки и работы с модулем уведомлений описаны тут [yii2-notifications](https://github.com/suver/yii2-notifications)


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
