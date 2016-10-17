<?php

namespace app\modules\users\controllers;

use app\components\BackendController;
use app\models\ProfileForm;
use app\models\SendForm;
use app\modules\users\models\search\UserSearch;
use app\modules\users\models\User;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * SendNotifications controller for the `users` module
 */
class SendNotificationsController extends BackendController
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
                        'roles' => ['@'],
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $module = \app\modules\users\Module::getInstance();
        $model = new SendForm;

        if ($model->load(\Yii::$app->request->post())) {
            $model->send();
            return $this->redirect(['/users/send-notifications']);
        }
        else {
            return $this->render('index', [
                'module' => $module,
                'model' => $model,
            ]);
        }
    }
}
