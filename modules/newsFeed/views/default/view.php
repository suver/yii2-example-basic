<?php

use yii\bootstrap\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\newsFeed\models\News */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Новостная лента'), 'url' => ['/news-feed/default/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Новости'), 'url' => \yii\helpers\ArrayHelper::merge(['/news-feed/default/index'],Yii::$app->request->get())];
$this->params['breadcrumbs'][] = $this->title;

\app\modules\newsFeed\assets\AppAsset::register($this);
?>

<div class="news-item">
    <div class="col-md-10">
        <div class="row">
            <div class="col-md-12">
                <img src="<?php echo $model->linkedFile('cover')->thumbnail('wide')->byDefault('/images/default-author.jpg')?>" height="258">
            </div>
        </div>
        <div class="row">
            <div class="col-md-10">
                <h2><?php echo Html::encode($model->title) ?></h2>
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
        <div class="row">
            <div class="col-md-12">
                <?php echo \suver\editor\TransformationWidget::widget(['message' => $model->body]) ?>
            </div>
        </div>
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
    <hr>
</div>
