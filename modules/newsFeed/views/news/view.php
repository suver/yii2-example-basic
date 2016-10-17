<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\newsFeed\models\News */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Новостная лента'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Новости'), 'url' => \yii\helpers\ArrayHelper::merge(['news'],Yii::$app->request->get())];
$this->params['breadcrumbs'][] = $this->title;

\app\modules\newsFeed\assets\AppAsset::register($this);
?>
<div class="news-feed-view">

    <div class="box">
        <div class="box-header">
            <?= Html::a(Yii::t('app', 'Редактировать'), \yii\helpers\ArrayHelper::merge(['update', 'id' => $model->id],Yii::$app->request->get()), ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'Удалить'), \yii\helpers\ArrayHelper::merge(['delete', 'id' => $model->id],Yii::$app->request->get()), [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Вы уверены что хотите удалить эту запись?'),
                    'method' => 'post',
                ],
            ]) ?>
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

                        <?php $widget = $module->detailViewWidget;
                        echo $widget::widget([
                            'model' => $model,
                            'attributes' => [
                                'id',
                                'slug',
                                'title',
                                [
                                    'attribute' => 'description',
                                    'format' => 'raw',
                                    'value' => \suver\editor\TransformationWidget::widget(['message' => $model->description]),
                                ],
                                [
                                    'attribute' => 'body',
                                    'format' => 'raw',
                                    'value' => \suver\editor\TransformationWidget::widget(['message' => $model->body]),
                                ],
                                [
                                    'attribute' => 'params',
                                    'format' => 'raw',
                                    'value' => \suver\editor\TransformationWidget::widget(['message' => $model->params]),
                                ],
                                [
                                    'label' => Yii::t('app', 'Автор'),
                                    'value' => isset($model->author) ? $model->author->username : '-',
                                ],
                                'created_at',
                                'updated_at',
                            ],
                        ]) ?>

                    </div>
                </div>
            </div>
        </div>
        <!-- /.box-body -->
    </div>

</div>
