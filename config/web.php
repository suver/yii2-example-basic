<?php

$params = require(__DIR__ . '/params.php');

Yii::setAlias('@storage', dirname(__DIR__) . '/web/storage');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'defaultRoute' => '/news-feed',
    'bootstrap' => [
        'notifications',
        'news-feed',
        'users',
        'log',
    ],
    'modules' => [
        'news-feed' => [
            'class' => 'app\modules\newsFeed\Module',
            'detailViewWidget' => '\app\widgets\DetailView',
            'gridViewWidget' => '\app\widgets\GridView',
        ],
        'users' => [
            'class' => 'app\modules\users\Module',
            'detailViewWidget' => '\app\widgets\DetailView',
            'gridViewWidget' => '\app\widgets\GridView',
        ],
        'books' => [
            'class' => 'app\modules\books\Module',
        ],
        'uploads' => [
            'class' => 'suver\behavior\upload\Module',
            'storageDomain' => '//newsfeed.dev/storage'
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
                [
                    'class' => '\suver\notifications\FlashNotificationsChannel',
                    'init' => [
                        'key' => 'info',
                    ],
                    'config' => [],
                ],
            ],
            'as access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'controllers'=>['notifications/default'],
                        'allow' => true,
                        'roles' => ['backendAccess']
                    ],
                    [
                        'controllers'=>['notifications/list'],
                        'allow' => true,
                        'roles' => ['backendAccess']
                    ],
                    [
                        'controllers'=>['notifications/template'],
                        'allow' => true,
                        'roles' => ['@']
                    ],
                ],
            ]
        ],
        'settings' => [
            'class' => 'app\modules\settings\Module',
        ],
        'noty' => [
            'class' => 'lo\modules\noty\Module',
        ],
    ],
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'cache' => 'cache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
            'enableAutoLogin' => true,
            // 'loginUrl' => ['user/login'],
            // ...
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'fMANnZvnjerpi4uWZC98gDNN15V80NeF',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
    ],

    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
