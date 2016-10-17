<?php

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'bootstrap' => [
        'notifications',
        'users',
        'log',
    ],
    'modules' => [
        'users' => [
            'class' => 'app\modules\users\Module',
            'detailViewWidget' => '\app\widgets\DetailView',
            'gridViewWidget' => '\app\widgets\GridView',
        ],
        'notifications' => [
            'class' => 'suver\notifications\Module',
            'detailViewWidget' => '\app\widgets\DetailView',
            'gridViewWidget' => '\app\widgets\GridView',
            'identityClass' => '\app\models\User',
            'channels' => [
                [
                    'class' => '\suver\notifications\EmailChannel',
                    'init' => [
                        'from' => 'mail@farpse.com',
                    ],
                    'config' => [
                        'class' => 'yii\swiftmailer\Mailer',
                        'transport' => [
                            'class' => 'Swift_SmtpTransport',
                            'host' => 'smtp.yandex.ru',
                            'username' => 'mail@farpse.com',
                            'password' => 'on82xni7',
                            'port' => '465',
                            'encryption' => 'ssl',
                        ],
                    ],
                ],
            ],
        ],
        'settings' => [
            'class' => 'app\modules\settings\Module',
        ],
    ],
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'cache' => 'cache',
        ],
        'user' => [
            'class' => 'app\models\User',
            'identityClass' => 'app\models\User',
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
            'enableAutoLogin' => true,
            // 'loginUrl' => ['user/login'],
            // ...
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
    ],
    'params' => $params,
    /*
    'controllerMap' => [
        'fixture' => [ // Fixture generation command line.
            'class' => 'yii\faker\FixtureController',
        ],
    ],
    */
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
