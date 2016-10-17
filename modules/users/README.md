Frapse Users
============
Your Users

Installation
------------

Install migrations

```bash
// install module migrations
yii migrate --migrationPath=@common/modules/users/migrations

// install system rbac migrations
yii migrate --migrationPath=@yii/rbac/migrations

// init system rbac migrations
yii rbac/init
```

Configurations
--------------

Add this module in your `modules` and `bootsrap` directive

```
'bootstrap' => [
    'users',
],
'modules' => [
    'users' => [
        'class' => 'common\modules\users\Module',
        //'detailViewWidget' => '\backend\widgets\DetailView',
        //'gridViewWidget' => '\backend\widgets\GridView',
    ],
],
'components' => [
    'user' => [
        'class' => 'common\modules\users\models\User',
        'identityClass' => 'common\modules\users\models\User',
    ],
];

```

or if you wont include module with access rule configuration you must configure module with `as access` directive like example


```
'bootstrap' => [
    'users',
],
'modules' => [
    'users' => [
        'class' => 'common\modules\users\Module',
        //'detailViewWidget' => '\backend\widgets\DetailView',
        //'gridViewWidget' => '\backend\widgets\GridView',
        'as access' => [
            'class' => 'yii\filters\AccessControl',
            'rules' => [
                [
                    'controllers'=>['users/default'],
                    'allow' => true,
                    'roles' => ['@']                        
                ],
            ]
        ]
    ],
],
'components' => [
    'user' => [
        'class' => 'common\modules\users\models\User',
        'identityClass' => 'common\modules\users\models\User',
    ],
];
```

How USE
-------

```php



```
