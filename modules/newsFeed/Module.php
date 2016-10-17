<?php

namespace app\modules\newsFeed;


use suver\notifications\Notifications;
use yii\base\BootstrapInterface;
use suver\notifications\models\Notifications as NotificationsModel;


/**
 * newsFeed module definition class
 */
class Module extends \yii\base\Module implements BootstrapInterface
{

    public $detailViewWidget = '\yii\widgets\DetailView';

    public $gridViewWidget = '\yii\grid\GridView';

    public $listViewWidget = 'yii\widgets\ListView';

    public $defaultListPerPage = 25;

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\newsFeed\controllers';

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
            $this->controllerNamespace = 'app\modules\newsFeed\commands';

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
                    'label' => 'Новостная лента',
                    'icon' => 'fa fa-newspaper-o',
                    'url' => ['/' . $this->id],
                    'alias' => [$this->id],
                    'items' => [
                        [
                            'label' => 'Список новостей',
                            'url' => ['/' . $this->id . '/news' ],
                            'alias' => [$this->id . '/news' ],
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

        $notifications = NotificationsModel::find()->andWhere(['sent_at' => null, 'channel' => 'flash-notifications'])->all();
        if($notifications) {
            foreach ($notifications as $notification) {
                $notify = Notifications::load($notification->id);
                if($notify && $notify->send()) {

                }
            }
        }

        // custom initialization code goes here
    }
}
