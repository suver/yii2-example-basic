<?php

namespace app\modules\users\controllers;

use app\components\BackendController;
use app\modules\users\models\search\UserSearch;
use app\modules\users\models\User;
use suver\notifications\Notifications;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Default controller for the `users` module
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {

        $module = \app\modules\users\Module::getInstance();

        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'module' => $module,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $module = \app\modules\users\Module::getInstance();
        if (\Yii::$app->request->isAjax) {
            return $this->renderAjax('view', [
                'module' => $module,
                'model' => $this->findModel($id),
            ]);
        }
        else {
            return $this->render('view', [
                'module' => $module,
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
        $post = \Yii::$app->request->post();
        if ($model->load($post)){
            $model->generateAuthKey();
            $model->setPassword($post['User']['password']);
            if($model->save()) {

                if($model->status == User::STATUS_INACTIVE) {
                    $params = [
                        'checkLink' => Url::to(['/site/check-email', 'token' => $model->password_reset_token], true),
                    ];
                    Notifications::get('user-registration-check-email', $model->id)->setParams($params)->setChannel('email')->send();
                }
                else {
                    $params = [];
                    Notifications::get('user-registration-success', $model->id)->setParams($params)->setChannel('email')->send();
                }

                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $module = \app\modules\users\Module::getInstance();
        $model = $this->findModel($id);

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {

            return $this->redirect(['view', 'id' => $model->id]);
        }
        else {
            return $this->render('update', [
                'module' => $module,
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
        if (($model = User::find()->andWhere(['id'=>$id])->one()) !== null) {
            return $model;
        }
        else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
