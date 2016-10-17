<?php

namespace app\modules\settings\controllers;

use app\components\BackendController;
use app\modules\settings\forms\SettingsForm;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

/**
 * Default controller for the `settings` module
 */
class DefaultController extends BackendController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $model = new SettingsForm();

        if ($model->load(\Yii::$app->request->post()) && $model->validate() && $model->save()) {
            // данные в $model удачно проверены

            // делаем что-то полезное с $model ...

            return $this->render('index', ['model' => $model]);
        } else {
            return $this->render('index', ['model' => $model]);
        }
    }
}
