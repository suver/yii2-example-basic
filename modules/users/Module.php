<?php

namespace app\modules\users;

use yii\base\BootstrapInterface;

/**
 * user module definition class
 */
class Module extends \yii\base\Module implements BootstrapInterface
{

    public $detailViewWidget = '\yii\widgets\DetailView';

    public $gridViewWidget = '\yii\grid\GridView';

    public $defaultUserListPerPage = 25;

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\users\controllers';

    public $menu = [];

    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        if ($app instanceof \yii\web\Application) {
            $app->getUrlManager()->addRules([
                ['class' => 'yii\web\UrlRule', 'pattern' => $this->id, 'route' => $this->id . '/default/index'],
                ['class' => 'yii\web\UrlRule', 'pattern' => $this->id . '/<controller:[\w-]+>', 'route' => $this->id . '/<controller>/index'],
                ['class' => 'yii\web\UrlRule', 'pattern' => $this->id . '/<controller:[\w-]+>/<id:[\d]+>', 'route' => $this->id . '/<controller>/view'],
                ['class' => 'yii\web\UrlRule', 'pattern' => $this->id . '/<controller:[\w-]+>/<action:[\w-]+>', 'route' => $this->id . '/<controller>/<action>'],
            ], false);
        } elseif ($app instanceof \yii\console\Application) {
            $this->controllerNamespace = 'app\modules\users\commands';

            /*$app->controllerMap[$this->id] = [
                'class' => 'yii\gii\console\GenerateController',
                'generators' => array_merge($this->coreGenerators(), $this->generators),
                'module' => $this,
            ];*/
        }
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // инициализация модуля с помощью конфигурации, загруженной из config.php
        \Yii::configure($this, require(__DIR__ . '/config.php'));

        if(empty($this->menu)) {
            $this->menu = [
                [
                    'label' => 'Пользователи',
                    'icon' => 'fa fa-users',
                    'url' => ['/' . $this->id],
                    'alias' => [$this->id],
                    'items' => [
                        [
                            'label' => 'Список пользователей',
                            'url' => ['/' . $this->id ],
                            'alias' => [$this->id ],
                        ],
                        /*[
                            'label' => 'Права доступа',
                            'url' => ['/' . $this->id . '/permissions'],
                            'alias' => [$this->id . '/permissions'],
                        ],*/
                    ],
                ],
            ];
        }


        // custom initialization code goes here
    }
}
