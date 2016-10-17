<?php

namespace app\modules\users\controllers;

use app\components\BackendController;
use app\models\ProfileForm;
use app\modules\users\models\search\UserSearch;
use app\modules\users\models\User;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Profile controller for the `users` module
 */
class ProfileController extends BackendController
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
        $model = $this->findModel(\Yii::$app->user->getId());

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            $model->changePassword();
            $model->notifySave();
            return $this->redirect(['index', 'id' => $model->id]);
        }
        else {
            return $this->render('index', [
                'module' => $module,
                'model' => $model,
            ]);
        }
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProfileForm::find()->andWhere(['id'=>$id])->one()) !== null) {
            return $model;
        }
        else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
