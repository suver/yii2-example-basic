<?php

namespace app\modules\settings;

/**
 * settings module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\settings\controllers';


    public $menu = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();



        $this->menu = [
            [
                'label' => 'Настройки',
                'icon' => 'fa fa-cogs',
                'url' => ['/settings'],
                'alias' => ['settings'],
                'items' => [
                    [
                        'label' => 'Настройки',
                        'url' => ['/settings'],
                        'alias' => ['settings'],
                    ],
                ],
            ],
        ];
        // custom initialization code goes here
    }
}
