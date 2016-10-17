<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\users\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Пользователи');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Управление пользователями'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Пользователи'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = $this->title;

\app\modules\users\assets\AppAsset::register($this);
?>
<div class="users-index">

    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="box">
        <div class="box-header">
            <?= Html::a(Yii::t('app', 'Новый пользователь'), ['create'], ['class' => 'btn btn-success']) ?>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap">
                <div class="row">
                    <div class="col-sm-6"></div>
                    <div class="col-sm-6"></div>
                </div>
                <div class="row">
                    <div class="col-sm-12">

                        <?php Pjax::begin(); ?>
                        <?php $widget = $module->gridViewWidget;
                        echo $widget::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'emptyText' => 'Пользователей не добавлено',
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],

                                //'id',
                                'username',
                                'email',
                                [
                                    'attribute' => 'role',
                                    'filter' => Yii::$app->authManager->getRoles(),
                                    'value' => function($model) {
                                        return $model->role;
                                    }
                                ],
                                [
                                    'attribute' => 'status',
                                    'filter' => \app\modules\users\models\User::getStatusList(),
                                    'value' => function($model) {
                                        return $model->getStatusLabel();
                                    }
                                ],
                                //'created_at',
                                //'updated_at',
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                ],
                            ],
                        ]); ?>
                        <?php Pjax::end(); ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.box-body -->
    </div>

</div>

