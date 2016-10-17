Frapse News Feed
================
News Feed



Installation
------------

Install migrations

```
./yii migrate --migrationPath=@common/modules/newsFeed/migrations
```


Configurations
--------------

Add this module in your `modules` and `bootsrap` directive

```
'bootstrap' => [
    'newsFeed',
],
'modules' => [
    'newsFeed' => [
        'class' => 'common\modules\newsFeed\Module',
        //'detailViewWidget' => '\backend\widgets\DetailView',
        //'gridViewWidget' => '\backend\widgets\GridView',
    ],
];

```

or if you wont include module with access rule configuration you must configure module with `as access` directive like example


```
'bootstrap' => [
    'newsFeed',
],
'modules' => [
    'newsFeed' => [
        'class' => 'common\modules\newsFeed\Module',
        //'detailViewWidget' => '\backend\widgets\DetailView',
        //'gridViewWidget' => '\backend\widgets\GridView',
        'as access' => [
            'class' => 'yii\filters\AccessControl',
            'rules' => [
                [
                    'controllers'=>['news-feed/default'],
                    'allow' => true,
                    'roles' => ['@']                        
                ],
            ]
        ]
    ],
];
```

How USE
-------

```php



```

