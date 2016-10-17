<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\users\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Управление пользователями'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Пользователи'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = $this->title;

\app\modules\users\assets\AppAsset::register($this);
?>
<div class="users-view">

    <div class="box">
        <div class="box-header">
            <?= Html::a(Yii::t('app', 'Редактировать'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'Удалить'), ['delete', 'id' => $model->id], [
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
                                [
                                    'attribute' => 'fullname',
                                    'format' => 'raw',
                                    'value' => $model->getFullname(),
                                ],
                                [
                                    'attribute' => 'avatar',
                                    'format' => 'raw',
                                    'value' => '<img src="' . $model->linkedFile('avatar')->thumbnail('medium')->byDefault('/images/default-author.jpg') . '" class="img-circle" width="200" height="200">',
                                ],
                                'username',
                                'email',
                                'phone',
                                [
                                    'attribute' => 'description',
                                    'format' => 'raw',
                                    'value' => \suver\editor\TransformationWidget::widget(['message' => $model->description]),
                                ],
                                [
                                    'attribute' => 'about',
                                    'format' => 'raw',
                                    'value' => \suver\editor\TransformationWidget::widget(['message' => $model->about]),
                                ],
                                [
                                    'attribute' => 'status',
                                    'format' => 'raw',
                                    'value' => $model->getStatusLabel(),
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
