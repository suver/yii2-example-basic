<?php

use yii\bootstrap\Html;

?>
<div class="news-item">
    <div class="row">
        <div class="col-md-2">
            <img src="<?php echo $model->linkedFile('cover')->thumbnail('small')->byDefault('/images/default-author.jpg')->getDomainPath()?>" class="img-circle" width="128" height="128">
        </div>
        <div class="col-md-10">
            <div class="row">
                <div class="col-md-10">
                    <h2><a href="/news-feed/default/<?php echo $model->id ?>"><?php echo Html::encode($model->title) ?></a></h2>
                </div>
                <div class="col-md-2">
                    <small><?php echo isset($model->author) ? $model->author->username : '-' ?></small>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?php echo \suver\editor\TransformationWidget::widget(['message' => $model->description]) ?>
                </div>
            </div>
            <?php if($fullNews) { ?>
                <div class="row">
                    <div class="col-md-12">
                        <?php echo \suver\editor\TransformationWidget::widget(['message' => $model->body]) ?>
                    </div>
                </div>
            <?php } ?>
            <div class="row">
                <div class="col-md-8">
                    <?php if(Yii::$app->user->can('updateNews')) { ?>
                        <?= Html::a(Yii::t('app', 'Редактировать'), \yii\helpers\ArrayHelper::merge(['/news-feed/default/update', 'id' => $model->id],Yii::$app->request->get()), ['class' => 'btn btn-primary']) ?>
                    <?php } ?>
                    <?php if(Yii::$app->user->can('deleteNews')) { ?>
                        <?= Html::a(Yii::t('app', 'Удалить'), \yii\helpers\ArrayHelper::merge(['/news-feed/default/delete', 'id' => $model->id],Yii::$app->request->get()), [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => Yii::t('app', 'Вы уверены что хотите удалить эту запись?'),
                                'method' => 'post',
                            ],
                        ]) ?>
                    <?php } ?>
                </div>
                <div class="col-md-4">
                    <?php echo Html::encode($model->updated_at) ?>
                </div>
            </div>
        </div>
    </div>
    <hr>
</div>
