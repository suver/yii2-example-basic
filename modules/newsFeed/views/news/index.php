<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\newsFeed\models\search\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Новости');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Новости'), 'url' => ['news/index']];
$this->params['breadcrumbs'][] = $this->title;

\app\modules\newsFeed\assets\AppAsset::register($this);
?>
<div class="news-feed-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="box">
        <div class="box-header">

            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?= Html::a(Yii::t('app', 'Добавить новость'), \yii\helpers\ArrayHelper::merge(['create'],Yii::$app->request->get()), ['class' => 'btn btn-success']) ?>

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
                            'emptyText' => 'Новостей не добавлено',
                            'summary' => 'Показано <b>{begin, number}-{end, number}</b> из <b>{totalCount, number}</b> {totalCount, plural, one{запись} other{записей}}',
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],

                                'id',
                                'slug',
                                'title',
                                'description',
                                [
                                    'label'=>Yii::t('app', 'Авторы'),
                                    'attribute' => 'created_by',
                                    'value'=> function($model) {
                                        return isset($model->author) ? $model->author->username : '-';
                                    },
                                ],
                                'created_at',
                                'updated_at',
                                ['class' => 'yii\grid\ActionColumn',
                                    'buttons' => [
                                        'view' => function ($url, $model) {
                                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',
                                                \yii\helpers\ArrayHelper::merge(['view', 'id' => $model->id],Yii::$app->request->get()) , ['class' => 'view', 'data-pjax' => '0']);
                                        },
                                        'update' => function ($url, $model) {
                                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                                                \yii\helpers\ArrayHelper::merge(['update', 'id' => $model->id],Yii::$app->request->get()) , ['class' => 'view', 'data-pjax' => '0']);
                                        },
                                        'delete' => function ($url, $model) {
                                            return Html::a('<span class="glyphicon glyphicon-trash"></span>',
                                                \yii\helpers\ArrayHelper::merge(['delete', 'id' => $model->id],Yii::$app->request->get()) , [
                                                    'class' => 'view', 'data-pjax' => '0',
                                                    'data-confirm' => Yii::t('app', 'Вы уверены что хотите удалить эту запись?'),
                                                    'data-method' => 'post',
                                                ]);
                                        },
                                    ],
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
