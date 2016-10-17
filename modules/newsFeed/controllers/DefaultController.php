<?php

namespace app\modules\newsFeed\controllers;

use app\modules\users\models\User;
use suver\notifications\Notifications;
use Yii;
use app\modules\newsFeed\models\News;
use app\modules\newsFeed\models\search\NewsSearch;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DefaultController implements the CRUD actions for News model.
 */
class DefaultController extends Controller
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
                        'actions' => ['index',],
                        'allow' => true,
                        'roles' => ['?', '@'],
                    ],
                    [
                        'actions' => ['view',],
                        'allow' => true,
                        'roles' => ['user', '@'],
                    ],
                    [
                        'actions' => ['create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['moderator'],
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
     * Lists all News models.
     * @return mixed
     */
    public function actionIndex()
    {
        //Notifications::get('user-registration-check-email', Yii::$app->user->getId())->setParams(['checkLink' => 'sdasdas'])->setChannel('email')->send();

        if(!Yii::$app->user->isGuest) {
            //Notifications::get('user-registration-check-email', Yii::$app->user->getId())->setParams(['checkLink' => 'sdasdas'])->sendUserChannels();
        }

        $module = \app\modules\newsFeed\Module::getInstance();

        $searchModel = new NewsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'module' => $module,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single News model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $module = \app\modules\newsFeed\Module::getInstance();
        return $this->render('view', [
            'module' => $module,
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new News model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $module = \app\modules\newsFeed\Module::getInstance();
        $model = new News();

        $model->on($model::EVENT_AFTER_INSERT, function($event) {
            $users = User::find()->andWhere(['status' => User::STATUS_ACTIVE])->all();
            foreach($users as $user) {
                Notifications::get('news-add', $user->id)
                    ->setParams(['newsLink' => Url::to(['/news-feed/default/' . $event->sender->id], true)])
                    ->holdOverUserChannels();
            }
        });

        $model->created_by = Yii::$app->user->getId();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'module' => $module,
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing News model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $module = \app\modules\newsFeed\Module::getInstance();
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'module' => $module,
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing News model.
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
     * Finds the News model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return News the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = News::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
